<?php

/**
 * Copyright (c) D3 Data Development (Inh. Thomas Dartsch)
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <info@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\Ordermanager\Application\Command;

use D3\ModCfg\Application\Model\d3cliutils;
use D3\Ordermanager\Application\Bridge\ShopContext;
use D3\Ordermanager\Application\Context\ExecutionMode;
use D3\Ordermanager\Application\Context\ProcessExecutionContext;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\Output\d3ordermanager_debugoutput;
use D3\Ordermanager\Application\Service\TaskGroupRunner;
use D3\Ordermanager\Core\Registry as ManagerRegistry;
use Exception;
use OxidEsales\Eshop\Core\ConfigFile;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ShopControl;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Stopwatch\Stopwatch;

class Run extends Command
{
    use LockableTrait;

    public const COMMAND_TITLE = 'Ordermanager cron run task';

    public const ARGUMENT_SHOPID = 'shop id';

    public const ARGUMENT_CJID = 'cronjob id';

    public function __construct(
        private TaskGroupRunner $runner,
        private ShopContext $shopContext
    ) {
        parent::__construct();
    }

    /**
     * @codeCoverageIgnore
     */
    protected function configure(): void
    {
        $this
            ->setName('d3:ordermanager:run')
            ->setDescription('run the task group with a defined Cronjob ID')
            ->setHelp('Enables remote execution of tasks of the order manager')
        ->addArgument(
            self::ARGUMENT_SHOPID,
            InputArgument::REQUIRED,
            'ID of the selected shop',
        )
        ->addArgument(
            self::ARGUMENT_CJID,
            InputArgument::REQUIRED,
            'ID of the task group to be started (can be set in the shop backend)',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new Stopwatch();
        $stopWatch->start(self::COMMAND_TITLE);

        /** @var ProcessExecutionContext $context */
        $context = ContainerFactory::getInstance()->getContainer()->get(ProcessExecutionContext::class);
        $context->setMode(ExecutionMode::fullRun());

        $debug = Registry::get(ConfigFile::class)->getVar('iDebug') && !defined('OXID_PHP_UNIT');

        $logger = ManagerRegistry::getLogger();
        $logger->notice(self::COMMAND_TITLE, ['status' => 'started']);
        $logger->info('set configuration', [
            'shopId' => (int) $input->getArgument(self::ARGUMENT_SHOPID),
            'cronId' => $input->getArgument(self::ARGUMENT_CJID),
        ]);

        if ($this->isLocked()) {
            $output->writeln('The command is already running in another process.');
            $logger->notice(self::COMMAND_TITLE, ['status' => 'aborted', 'reason' => 'already running']);
            return Command::SUCCESS;
        }

        $output->writeln('Try to run Ordermanager run task');

        try {
            $exitCode = Command::SUCCESS;
            $statusMessage = '<info>Successfully finished.</info>';

            // @codeCoverageIgnoreStart
            if ($debug) {
                $cliUtils    = oxNew(d3cliutils::class);
                $shopControl = oxNew(ShopControl::class);
                $cliUtils->startMonitor($shopControl);
            }
            // @codeCoverageIgnoreEnd

            $this->shopContext->initializeLanguage();

            $this->runner->run(
                (int)$input->getArgument(self::ARGUMENT_SHOPID),
                $input->getArgument(self::ARGUMENT_CJID)
            );

            // @codeCoverageIgnoreStart
            if ($debug) {
                $log = $cliUtils->profilingFormMonitorMessage($shopControl);
                oxNew(d3ordermanager_debugoutput::class)->output($log);
            }
            // @codeCoverageIgnoreEnd
        } catch (Exception $exception) {
            $logger->error(
                Constants::OXID_MODULE_ID . ': ' . $exception->getMessage(),
                ['exception' => $exception]
            );
            $statusMessage = '<error>Error: ' . $exception->getMessage() . '</error>';
            $exitCode = Command::FAILURE;
        } finally {
            $this->release();
            $performance = (string)$stopWatch->stop(self::COMMAND_TITLE);
            $logger->notice(self::COMMAND_TITLE, [
                'status' => 'finished',
                'exit code' => $exitCode,
                'performance' => $performance,
            ]);
            $output->writeln($statusMessage . ' ' . ($output->isVerbose() ? $performance : ''));
            $context->resetMode();
            return $exitCode;
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function isLocked(): bool
    {
        return !$this->lock();
    }
}
