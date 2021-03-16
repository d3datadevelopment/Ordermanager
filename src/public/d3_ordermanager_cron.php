<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * http://www.shopmodule.com
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      http://www.oxidmodule.com
 */

namespace D3\Ordermanager\publicDir;

use D3\ModCfg\Application\Model\d3cliutils;
use D3\ModCfg\Application\Model\Exception\d3PreventExitException;
use D3\Ordermanager\Application\Controller\d3ordermanager_response as ResponseController;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\Output\d3ordermanager_debugoutput;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\ConfigFile;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\Eshop\Core\ShopControl;
use RuntimeException;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;

// @codeCoverageIgnoreStart

$bootstrapFileName = getenv('ESHOP_BOOTSTRAP_PATH');
if (!empty($bootstrapFileName)) {
    $bootstrapFileName = realpath(trim(getenv('ESHOP_BOOTSTRAP_PATH')));
} else {
    $count = 0;
    $bootstrapFileName = '../../../source/bootstrap.php';
    $currentDirectory = __DIR__ . '/';
    while ($count < 5) {
        $count++;
        if (file_exists($currentDirectory . $bootstrapFileName)) {
            $bootstrapFileName = $currentDirectory . $bootstrapFileName;
            break;
        }
        $bootstrapFileName = '../' . $bootstrapFileName;
    }
}

if (!(file_exists($bootstrapFileName) && !is_dir($bootstrapFileName))) {
    $items = [
        "Unable to find eShop bootstrap.php file.",
        "You can override the path by using ESHOP_BOOTSTRAP_PATH environment variable.",
        "\n"
    ];

    $message = implode(" ", $items);

    die($message);
}

if (false === defined('OXID_PHP_UNIT')) {
    require_once($bootstrapFileName);

    // required for recalculating order and generating pdf
    define('OX_IS_ADMIN', true);
}

if (false == function_exists('isAdmin')) {
    /**
     * @return bool
     */
    function isAdmin()
    {
        if (defined('OX_IS_ADMIN')) {
            return OX_IS_ADMIN;
        }

        return true;
    }
}

// set language
$options = getopt('l:', ["lang:"]);
$searchedValue = $options ? getopt('l:', ["lang:"])['lang'] : 0;
Registry::getLang()->setTplLanguage(
    current(
        array_filter(
            Registry::getLang()->getLanguageArray(),
            function ($e) use (&$searchedValue) {
                return $e->abbr == $searchedValue;
            }
        )
    )->id
);
// @codeCoverageIgnoreEnd

// ToDo: extract to separate file because of circular reference in d3ordermanager_execute class
class d3_ordermanager_cron extends CLI
{
    const OPTION_VERSION = 'version';
    const OPTION_QUIET = 'quiet';
    const OPTION_LANG = 'lang';

    const COMMAND_RUN = 'run';
    const COMMAND_STATUS = 'status';

    const ARGUMENT_SHOPID = 'shop id';
    const ARGUMENT_CJID = 'cronjob id';
    const ARGUMENT_KEY = 'key';

    public function __construct()
    {
        // there are argv setting in CLI mode only
        if ($this->isCLI()) {
            parent::__construct();
        }
    }

    /**
     * @return bool
     */
    public function isCLI()
    {
        return 'cli' == php_sapi_name();
    }

    /**
     * @param Options $options
     *
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    protected function setup(Options $options)
    {
        $lang = Registry::getLang();

        $sShopIdList = implode(
            $lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_ENCLOSER'),
            Registry::getConfig()->getShopIds()
        );
        $sCJIDList = implode(
            $lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_ENCLOSER'),
            array_map(
                function ($entry) {
                    return $entry['id'];
                },
                d3GetModCfgDIC()->get(Manager::class)->getAvailableCronjobIds()
            )
        );
        $sLangList = implode(
            $lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_ENCLOSER'),
            array_map(
                function ($e) {
                    return $e->abbr;
                },
                Registry::getLang()->getLanguageArray()
            )
        );

        $options->setHelp($lang->translateString('D3_ORDERMANAGER_CLI_HELP'));
        $options->registerOption(self::OPTION_VERSION, $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_VERSION'), 'v');
        $options->registerOption(self::OPTION_QUIET, $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_QUIET'), 'q');
        $options->registerOption(self::OPTION_LANG, sprintf($lang->translateString('D3_ORDERMANAGER_CLI_OPTION_LANG'), $sLangList), null, 'language');

        $options->registerCommand(self::COMMAND_RUN, $lang->translateString('D3_ORDERMANAGER_CLI_COMMAND_RUN'));
        $options->registerCommand(self::COMMAND_STATUS, $lang->translateString('D3_ORDERMANAGER_CLI_COMMAND_STATUS'));

        $options->registerArgument(self::ARGUMENT_SHOPID, sprintf($lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_SHOPID'), $sShopIdList), false);
        $options->registerArgument(self::ARGUMENT_CJID, sprintf($lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_CJID'), $sCJIDList), false);
        $options->registerArgument(self::ARGUMENT_KEY, $lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_KEY'), false);
    }

    /**
     * retranslate default messages
     */
    protected function parseOptions()
    {
        $lang = Registry::getLang();

        parent::parseOptions();

        $this->options->registerOption('help', $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_HELP'), 'h');
        $this->options->registerOption('no-colors', $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_NOCOLORS'));
        $this->options->registerOption('loglevel', $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_LOGLEVELS'), null, 'level');
    }

    /**
     * @param Options $options
     *
     * @throws DBALException
     * @throws Exception
     */
    protected function main(Options $options)
    {
        if ( $options->getOpt( self::OPTION_VERSION ) ) {
            $oModule = oxNew( Module::class );
            $oModule->load( 'd3ordermanager' );
            $this->info( $oModule->getModuleData()['version'] );

            return;
        }

        if ( $options->getOpt( self::OPTION_QUIET ) ) {
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class)->setVariable( 'd3ordermanager_quiet', true );
        }

        $arguments = $options->getArgs();
        $aTranslation         = [];
        $aTranslation['shp']  = isset( $arguments[0] ) ? $arguments[0] : '';
        $aTranslation['cjid'] = isset( $arguments[1] ) ? $arguments[1] : '';
        $aTranslation['key']  = isset( $arguments[2] ) ? $arguments[2] : '';

        $_GET = array_merge( $_GET, $aTranslation );

        try {
            if ($aTranslation['shp']) {
                if (false === in_array($aTranslation['shp'], Registry::getConfig()->getShopIds())) {
                    throw new RuntimeException(Registry::getLang()->translateString('D3_ORDERMANAGER_CLI_COMMON_UNVALIDSHOPID'));
                }
                Registry::getConfig()->setShopId( (int) $aTranslation['shp'] );
            }

            /** @var $oResponse ResponseController */
            $oResponse = d3GetModCfgDIC()->get( ResponseController::class );

            switch ( $options->getCmd() ) {
                case self::COMMAND_RUN:
                    $oResponse->initCli();
                    if ( !$options->getOpt( self::OPTION_QUIET ) ) {
                        $this->success(
                            Registry::getLang()->translateString('D3_ORDERMANAGER_CLI_FINISHED_SUCCESSFULLY')
                        );
                    }
                    break;
                case self::COMMAND_STATUS:
                    $this->info(implode(PHP_EOL, $oResponse->getLastExecDateInfo()));
                    break;
                default:

                    // old command without 'run' task
                    if (false === in_array($aTranslation['cjid'], ['', false, null], true)) {
                        if (false === in_array($aTranslation['cjid'], array_map(
                                function ($entry) {
                                    return $entry['id'];
                                },
                                d3GetModCfgDIC()->get(Manager::class)->getAvailableCronjobIds()
                            ))
                        ) {
                            throw new RuntimeException(Registry::getLang()->translateString('D3_ORDERMANAGER_CLI_COMMON_UNVALIDCJID'));
                        }
                        $oResponse->initCli();
                        if ( !$options->getOpt( self::OPTION_QUIET ) ) {
                            $this->success(
                                Registry::getLang()->translateString('D3_ORDERMANAGER_CLI_FINISHED_SUCCESSFULLY')
                            );
                        }
                    } else {
                        echo $this->translateFixedStrings( $options->help() );
                    }
            }
        } catch ( Exception $oEx ) {
            if (!Registry::getSession()->getVariable('d3ordermanager_quiet')) {
                $this->error( $oEx->getMessage() );
            }
        } finally {
            /** @var Config $config */
            $config = d3GetModCfgDIC()->get( 'd3ox.ordermanager.' . Config::class );
            // @codeCoverageIgnoreStart
            if (false === defined('OXID_PHP_UNIT')) {
                $config->pageClose();
            }
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * prevent code exit while coverage check
     * @codeCoverageIgnore
     *
     * @throws DBALException
     */
    public function run()
    {
        $blDebug = (bool) Registry::get(ConfigFile::class)->getVar('iDebug');

        if ($blDebug) {
            $cliUtils = oxNew(d3cliutils::class);
            $shopControl = oxNew(ShopControl::class);
            $cliUtils->startMonitor($shopControl);
        }

        // run cron script from browser
        if (false === $this->isCLI()) {
            // browser call don't handle CLI options and arguments
            /** @var $oResponse ResponseController */
            $oResponse = d3GetModCfgDIC()->get( ResponseController::class );
            $oResponse->init();
        } else {
            try {
                parent::run();
            } catch (d3PreventExitException $e) {}
        }

        if ($blDebug) {
            $log = $cliUtils->profilingFormMonitorMessage($shopControl);
            oxNew(d3ordermanager_debugoutput::class)->output($log);
        }
    }

    /**
     * @throws d3PreventExitException
     */
    protected function execute()
    {
        parent::execute();

        /** @var d3PreventExitException $e */
        $e = oxNew(d3PreventExitException::class);
        throw $e;
    }

    /**
     * @param $text
     * @return string
     */
    public function translateFixedStrings($text)
    {
        $search = [
            'This tool accepts a command as first parameter as outlined below:'
        ];

        $replace = [
            Registry::getLang()->translateString('D3_ORDERMANAGER_CLI_COMMAND')
        ];

        return str_replace($search, $replace, $text);
    }
}

// @codeCoverageIgnoreStart
/** @var d3_ordermanager_cron $cli */
$cli = d3GetModCfgDIC()->get(d3_ordermanager_cron::class);
if (false === defined('OXID_PHP_UNIT')) {
    try {
        $cli->run();
    } catch ( Exception $e) {
        $cli->error($e->getMessage());
    }
}
// @codeCoverageIgnoreEnd
