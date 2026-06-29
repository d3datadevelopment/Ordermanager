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

namespace D3\Ordermanager\Application\Controller\Admin;

use Assert\Assert;
use Assert\InvalidArgumentException;
use D3\ModCfg\Application\Model\d3filesystem;
use D3\ModCfg\Application\Model\d3str;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Exception\d3ParameterNotFoundException;
use D3\ModCfg\Application\Model\Exception\d3ShopCompatibilityAdapterException;
use D3\ModCfg\Application\Model\Log\d3log;
use D3\Ordermanager\Application\Context\ExecutionMode;
use D3\Ordermanager\Application\Context\ProcessExecutionContext;
use D3\Ordermanager\Application\Model\Constants;
use D3\Ordermanager\Application\Model\d3ordermanager as Manager;
use D3\Ordermanager\Application\Model\d3ordermanager_configurationcheck;
use D3\Ordermanager\Application\Model\d3ordermanager_execute as ManagerExecuteModel;
use D3\Ordermanager\Application\Model\d3ordermanager_toorderassignment as ToItemAssignmentModel;
use D3\Ordermanager\Application\Model\d3ordermanagerlist;
use D3\Ordermanager\Application\Model\d3ordermanagerlist as ManagerListModel;
use D3\Ordermanager\Application\Model\Events\PartiallyRunEvent;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementAbstract;
use D3\Ordermanager\Application\Model\Exceptions\d3ActionRequirementInterface;
use D3\Ordermanager\Application\Model\Exceptions\d3ordermanager_templaterendererExceptionInterface;
use D3\Ordermanager\Application\Model\Exceptions\executionExceptionInterface;
use D3\Ordermanager\Application\Model\Trigger;
use D3\Ordermanager\Core\ModCfgTrait;
use D3\Ordermanager\Core\Registry as ManagerRegistry;
use Doctrine\DBAL\Exception as DBALException;
use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Application\Model\Order;
use OxidEsales\Eshop\Application\Model\Order as ItemModel;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Language;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Session;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\Twig\Resolver\TemplateChain\TemplateType\NonTemplateFilenameException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class d3_ordermanager_jobs extends AdminDetailsController
{
    use ModCfgTrait;

    /** @var ManagerListModel */
    protected $_aJobList;

    protected $_sHelpLinkMLAdd;

    public $_sThisTemplate = '@' . Constants::OXID_MODULE_ID . '/admin/d3_ordermanager_jobs';

    /**
     * @codeCoverageIgnore
     */
    public function getItemObject(): ItemModel
    {
        return oxNew(ItemModel::class);
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function render(): string
    {
        $tpl = parent::render();

        $soxId = $this->getEditObjectId();
        $this->addTplParam("oxid", $soxId);

        if ($soxId != "-1") {
            $oItem = $this->getItemObject();
            $oItem->load($soxId);
            $this->addTplParam("edit", $oItem);
        }

        $sJobFolder = $this->d3GetSession()->getVariable('d3FolderSelect');
        $this->addTplParam("jobfolder", $sJobFolder);
        $this->_aJobList = $this->_d3GetManuallyManagerJobs($sJobFolder);

        return $tpl;
    }

    /**
     * @codeCoverageIgnore
     */
    public function d3GetSession(): Session
    {
        return Registry::getSession();
    }

    public function changeFolder(): void
    {
        $this->d3GetSession()->setVariable(
            'd3FolderSelect',
            Registry::getRequest()->getRequestEscapedParameter('jobfolder')
        );
    }

    /**
     * @codeCoverageIgnore
     */
    public function getManagerList(): ManagerListModel
    {
        return oxNew(ManagerListModel::class);
    }

    public function d3GetManagerJobs(): ManagerListModel
    {
        $oManagerList = $this->getManagerList();
        $oManagerList->getList();

        return $oManagerList;
    }

    /**
     * @param $sFolderId
     *
     * @return ManagerListModel
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws ReflectionException
     * @throws StandardException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    protected function _d3GetManuallyManagerJobs($sFolderId): ManagerListModel
    {
        try {
            $oManagerList = $this->getManagerList();
            $oList = $oManagerList->d3GetManuallyManagerJobsByFolder($sFolderId);

            $filtered = array_filter(
                $oList->getArray(),
                fn($oManager) => $this->shouldKeepManager($oManager)
            );

            $newList = oxNew(d3ordermanagerlist::class);
            $newList->assign($filtered);

            return $newList;
        } catch (d3ActionRequirementInterface $d3ActionRequirement) {
            Registry::getUtilsView()->addErrorToDisplay($d3ActionRequirement);
        }

        return oxNew(ManagerListModel::class);
    }

    /**
     * @param $oManager
     *
     * @return bool
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ActionRequirementAbstract
     * @throws ReflectionException
     * @throws d3ParameterNotFoundException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    private function shouldKeepManager($oManager): bool
    {
        $oManagerExecute = $this->getManagerExecute($oManager);

        return !$oManager->getValue('sManuallyExecMeetCondition')
               || $oManagerExecute->orderMeetsConditions($this->getEditObjectId());
    }

    public function d3GetJobList(): array
    {
        return $this->_aJobList->getArray();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getManager(): Manager
    {
        return oxNew(Manager::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getManagerExecute(Manager $oManager): ManagerExecuteModel
    {
        return oxNew(ManagerExecuteModel::class, $oManager);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function d3execordermanager(): void
    {
        /** @var ProcessExecutionContext $context */
        $context = ContainerFactory::getInstance()->getContainer()->get(ProcessExecutionContext::class);

        try {
            $context->setMode(ExecutionMode::partialRun());

            $managerId = Registry::getRequest()->getRequestEscapedParameter('ordermanagerid');

            $this->assertSupported($managerId);

            $event = $this->getEvent($managerId, $this->getEditObjectId());
            $this->getEventDispatcher()->dispatch($event);
        } catch (executionExceptionInterface|d3ActionRequirementInterface | d3ordermanager_templaterendererExceptionInterface | InvalidArgumentException $oEx) {
            // @codeCoverageIgnoreStart
            if (!defined('OXID_PHP_UNIT')) {  // ToDo: disable it by setting a nullLogger
                ManagerRegistry::getLogger()->error($oEx);
            }

            // @codeCoverageIgnoreEnd

            $this->d3GetOrderManagerLog()->alert(
                self::class,
                __FUNCTION__,
                __LINE__,
                "execution error",
                $oEx->getMessage()
            );

            Registry::getUtilsView()->addErrorToDisplay($oEx);
        } finally {
            $context->resetMode();
            ManagerRegistry::getLogger()->notice('manually executed task', [
                'status'   => 'finished',
            ]);
            Registry::getConfig()->setAdminMode(true);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getEventDispatcher(): EventDispatcherInterface
    {
        return ContainerFactory::getInstance()->getContainer()->get(EventDispatcherInterface::class);
    }

    /**
     * @codeCoverageIgnore
     */
    protected function getEvent(string $managerId, string $itemId): PartiallyRunEvent
    {
        return oxNew(PartiallyRunEvent::class, $managerId, $itemId);
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function d3ExecChangedOrderManager(): void
    {
        try {
            $request = Registry::getRequest();

            $oManager = $this->getManager();
            $oManager->load($request->getRequestEscapedParameter('ordermanagerid'));
            $oManager->setEditedValues($request->getRequestEscapedParameter('aContent'));
            $oManagerExec = $this->getManagerExecute($oManager);

            $this->checkForConfigurationException($oManager);

            if (!$oManager->getValue('sManuallyExecMeetCondition') ||
                $oManagerExec->orderMeetsConditions($this->getEditObjectId())
            ) {
                $item = oxNew(Order::class);
                $item->load($this->getEditObjectId());
                $oManagerExec->exec4order($item);
                $oManagerExec->finishJobExecution();
            }
        } catch (executionExceptionInterface|d3ActionRequirementInterface|d3ordermanager_templaterendererExceptionInterface $e) {
            // @codeCoverageIgnoreStart
            if (!defined('OXID_PHP_UNIT')) {
                $logger = ManagerRegistry::getLogger();
                $logger->error($e);
            }

            // @codeCoverageIgnoreEnd

            $this->d3GetOrderManagerLog()->alert(
                self::class,
                __FUNCTION__,
                __LINE__,
                "execution error",
                $e->getMessage()
            );

            Registry::getUtilsView()->addErrorToDisplay($e);
        } finally {
            Registry::getConfig()->setAdminMode(true);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getOrderManagerAssignment(Manager $oManager): ToItemAssignmentModel
    {
        return oxNew(ToItemAssignmentModel::class, $oManager);
    }

    /**
     * @throws d3ParameterNotFoundException
     */
    public function d3resetOrderManagerAssignment(): void
    {
        $oManager = $this->getManager();
        $oAssignment = $this->getOrderManagerAssignment($oManager);
        $oAssignment->resetAssignment(
            Registry::getRequest()->getRequestEscapedParameter('ordermanagerid'),
            $this->getEditObjectId()
        );
    }

    /**
     * @return mixed
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     */
    public function getFolderList()
    {
        $oManager = $this->getManager();
        return $oManager->d3getSelectableFolderList();
    }

    /**
     * @throws DBALException
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws StandardException
     * @throws d3ShopCompatibilityAdapterException
     * @throws d3_cfg_mod_exception
     */
    public function execChangedContents(): void
    {
        try {
            $sItemId = $this->getEditObjectId();
            $oManager = $this->getManager();
            $oManager->load(Registry::getRequest()->getRequestEscapedParameter('ordermanagerid'));

            // check configuration exceptions
            $this->checkForConfigurationException($oManager);

            $contents = $oManager->getEditableContent($sItemId);
            $this->addTplParam('aMailContent', $contents);

            $field = oxNew(Field::class);
            $field->setValue($contents['html'] ?? '');
            $object = oxNew(BaseModel::class);
            $object->__set(
                'aContent[mail][html]',
                $field
            );
            $this->addTplParam("htmleditor", $this->generateTextEditor("95%", 180, $object, "aContent[mail][html]", "list.tpl.css"));

            $this->addTplParam('sAction', __FUNCTION__);
            $this->addTplParam('oManager', $oManager);
        } catch (executionExceptionInterface | d3ActionRequirementInterface | d3ordermanager_templaterendererExceptionInterface | NonTemplateFilenameException $oEx) {
            // @codeCoverageIgnoreStart
            if (! defined('OXID_PHP_UNIT')) {
                $logger = ManagerRegistry::getLogger();
                $logger->error($oEx->getMessage());
            }

            // @codeCoverageIgnoreEnd

            $this->d3GetOrderManagerLog()->log(d3log::ALERT, self::class, __FUNCTION__, __LINE__, "stop execution because configuration error", $oEx->getMessage());

            Registry::getUtilsView()->addErrorToDisplay($oEx);
        } finally {
            Registry::getConfig()->setAdminMode(true);
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getUserMessages(): array
    {
        return [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getLang(): Language
    {
        return Registry::getLang();
    }

    public function getHelpURL(): string
    {
        $sUrl = $this->d3GetOrderManagerConfig()->getHelpURL();
        $oD3Str = $this->createD3Str();

        if ($this->_sHelpLinkMLAdd) {
            $sUrl .= $oD3Str->unprefixedslashit($this->getLang()->translateString($this->_sHelpLinkMLAdd));
        }

        $oFS = $this->createD3Filesystem();
        $aFileName = $oFS->splitFilename($sUrl);

        // has no extension
        if (!$aFileName['ext']) {
            return $oD3Str->trailingslashit($sUrl);
        }

        return $sUrl;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getLink(): string
    {
        return '';
    }

    /**
     * @throws d3ActionRequirementInterface
     */
    protected function checkForConfigurationException(Manager $oManager): void
    {
        $confCheck = $this->createConfigurationCheck($oManager);
        $confCheck->checkThrowingExceptions($oManager->getValue('sManuallyExecMeetCondition') ?
            d3ordermanager_configurationcheck::REQUIREMENTS_AND_ACTIONS :
            d3ordermanager_configurationcheck::ACTIONS_ONLY);
    }

    /**
     * @codeCoverageIgnore
     */
    public function createD3Str(): d3str
    {
        return oxNew(d3str::class);
    }

    /**
     * @codeCoverageIgnore
     */
    public function createD3Filesystem(): d3filesystem
    {
        return oxNew(d3filesystem::class);
    }

    /**
     * @codeCoverageIgnore
     * @param Manager $oManager
     * @return d3ordermanager_configurationcheck
     */
    public function createConfigurationCheck(Manager $oManager): d3ordermanager_configurationcheck
    {
        return oxNew(d3ordermanager_configurationcheck::class, $oManager);
    }

    /**
     * @param string $managerId
     *
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function assertSupported(string $managerId): void
    {
        $manager   = $this->getManager();
        $manager->load($managerId);
        Assert::that($manager->supports(Trigger::manually()))->true(
            Registry::getLang()->translateString(
                'D3_ORDERMANAGER_ORDERMAIN_UNSUPPORTED',
                null,
                true
            )
        );
    }
}
