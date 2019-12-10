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

use D3\Ordermanager\Application\Controller\d3ordermanager_response;
use D3\Ordermanager\Application\Model\d3ordermanager;
use Doctrine\DBAL\DBALException;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Module\Module;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Session;
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Exception;
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

require_once($bootstrapFileName);

// required for recalculating order and generating pdf
define('OX_IS_ADMIN', true);

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
$searchedValue = getopt(null, ["lang:"])['lang'];
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

class d3_ordermanager_cron extends CLI
{
    public function __construct()
    {
        // there are argv setting in CLI mode only
        if ('cli' == php_sapi_name()) {
            parent::__construct();
        }
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
                d3GetModCfgDIC()->get(d3ordermanager::class)->getAvailableCronjobIds()
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
        $options->registerOption('version', $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_VERSION'), 'v');
        $options->registerOption('quiet', $lang->translateString('D3_ORDERMANAGER_CLI_OPTION_QUIET'), 'q');
        $options->registerOption('lang', sprintf($lang->translateString('D3_ORDERMANAGER_CLI_OPTION_LANG'), $sLangList), null, 'language');

        $options->registerCommand('run', $lang->translateString('D3_ORDERMANAGER_CLI_COMMAND_RUN'));
        $options->registerCommand('status', $lang->translateString('D3_ORDERMANAGER_CLI_COMMAND_STATUS'));

        $options->registerArgument('shop id', sprintf($lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_SHOPID'), $sShopIdList), false);
        $options->registerArgument('cronjob id', sprintf($lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_CJID'), $sCJIDList), false);
        $options->registerArgument('key', $lang->translateString('D3_ORDERMANAGER_CLI_ARGUMENT_KEY'), false);
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
     * @throws DBALException
     * @throws \Exception
     */
    protected function main(Options $options)
    {
        if ( $options->getOpt( 'version' ) ) {
            $oModule = oxNew( Module::class );
            $oModule->load( 'd3ordermanager' );
            $this->info( $oModule->getModuleData()['version'] );

            return;
        }

        if ( $options->getOpt( 'quiet' ) ) {
            d3GetModCfgDIC()->get('d3ox.ordermanager.'.Session::class)->setVariable( 'd3ordermanager_quiet', true );
        }

        $arguments = $options->getArgs();
        $aTranslation         = [];
        $aTranslation['shp']  = isset( $arguments[0] ) ? $arguments[0] : '';
        $aTranslation['cjid'] = isset( $arguments[1] ) ? $arguments[1] : '';
        $aTranslation['key']  = isset( $arguments[2] ) ? $arguments[2] : '';

        $_GET = array_merge( $_GET, $aTranslation );

        try {
            /** @var $oResponse d3ordermanager_response */
            $oResponse = d3GetModCfgDIC()->get( d3ordermanager_response::class );

            switch ( $options->getCmd() ) {
                case 'run':
                    $oResponse->init();
                    if ( !$options->getOpt( 'quiet' ) ) {
                        $this->success('script successfully finished');
                    }
                    break;
                case 'status':
                    $this->info(implode(PHP_EOL, $oResponse->getLastExecDateInfo()));
                    break;
                default:
                    echo $this->translateFixedStrings($options->help());
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
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function run()
    {
        if (false === defined('OXID_PHP_UNIT')) {
            if ('cli' != php_sapi_name()) {
                // browser call don't handle CLI options and arguments
                /** @var $oResponse d3ordermanager_response */
                $oResponse = d3GetModCfgDIC()->get( d3ordermanager_response::class );
                $oResponse->init();
            } else {
                parent::run();
            }
        } else {
            if ('cli' != php_sapi_name()) {
                throw new Exception('This has to be run from the command line');
            }

            $this->setup($this->options);
            $this->registerDefaultOptions();
            $this->parseOptions();
            $this->handleDefaultOptions();
            $this->setupLogging();
            $this->checkArgments();
            $this->execute();
        }
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
$cli = new d3_ordermanager_cron();
if (false === defined('OXID_PHP_UNIT')) {
    try {
        $cli->run();
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
}
// @codeCoverageIgnoreEnd
