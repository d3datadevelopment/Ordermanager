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

use D3\Ordermanager\Application\Bridge\ShopContext;
use D3\Ordermanager\Application\Controller\d3ordermanager_response as ResponseController;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Service\TaskGroupStatisticService;
use D3\Ordermanager\Core\Registry as ManagerRegistry;
use Doctrine\DBAL\Driver\Exception as DBALDriverException;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Stopwatch\Stopwatch;

class Statistic extends Command
{
    public const COMMAND_TITLE = 'Ordermanager cron statistic task';

    public const ARGUMENT_SHOPID = 'shop id';

    public function __construct(
        private TaskGroupStatisticService $statisticService,
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
            ->setName('d3:ordermanager:statistic')
            ->setDescription('display execution status statistic')
            ->setHelp('Enables remote execution of tasks of the order manager')
        ->addArgument(
            self::ARGUMENT_SHOPID,
            InputArgument::REQUIRED,
            'ID of the selected shop',
        );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws DBALDriverException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $stopWatch = new Stopwatch();
        $stopWatch->start(self::COMMAND_TITLE);

        $logger = ManagerRegistry::getLogger();
        $logger->notice(self::COMMAND_TITLE, ['status' => 'started']);
        $logger->info('set configuration', [
            'shopId' => (int) $input->getArgument(self::ARGUMENT_SHOPID),
        ]);

        try {
            $exitCode = Command::SUCCESS;
            $statusMessage = '<info>Successfully finished.</info>';

            $this->shopContext->initializeLanguage();

            $result = $this->statisticService->getStatistic(
                (int)$input->getArgument(self::ARGUMENT_SHOPID)
            );

            $output->writeln($result);

        } catch (Exception $exception) {
            $logger->error(
                Constants::OXID_MODULE_ID . ': ' . $exception->getMessage(),
                ['exception' => $exception]
            );
            $statusMessage = '<error>Error: ' . $exception->getMessage() . '</error>';
            $exitCode = Command::FAILURE;
        } finally {
            $performance = (string)$stopWatch->stop(self::COMMAND_TITLE);
            $logger->notice(self::COMMAND_TITLE, [
                'status' => 'finished',
                'exit code' => $exitCode,
                'performance' => $performance,
            ]);
            $output->writeln($statusMessage . ' ' . ($output->isVerbose() ? $performance : ''));
            return $exitCode;
        }
    }

    /**
     * @return ResponseController
     * @codeCoverageIgnore
     */
    protected function createResponseController(): ResponseController
    {
        return oxNew(ResponseController::class);
    }
}
