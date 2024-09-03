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

namespace D3\Ordermanager\tests\unit;

use Assert\Assert;
use D3\DIContainerHandler\d3DicException;
use D3\DIContainerHandler\d3DicHandler;
use D3\ModCfg\Application\Model\Configuration\d3_cfg_mod;
use D3\ModCfg\Application\Model\Exception\d3_cfg_mod_exception;
use D3\ModCfg\Application\Model\Log\d3NullLogger;
use D3\ModCfg\Tests\unit\d3ModCfgUnitTestCase;
use D3\Ordermanager\Application\Model\d3ordermanager;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\Bridge\ShopConfigurationDaoBridgeInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Configuration\DataObject\ShopConfiguration;
use OxidEsales\EshopCommunity\Internal\Framework\Module\State\ModuleStateService;
use OxidEsales\EshopCommunity\Internal\Framework\Module\State\ModuleStateServiceInterface;

abstract class d3OrdermanagerUnitTestCase extends d3ModCfgUnitTestCase
{
    public const D3CLI_COLOR_YELLOW    = "\033[33m";
    public const D3CLI_COLOR_DEFAULT   = "\033[0m";

    protected $_sCurrentLicenseKeyBackup;

    public $sModId = 'd3_ordermanager';

    /**
     * check for dependent 3rd party modules required for coverage report
     */
    public function setUpBeforeSuite(): void
    {
        // force start session to prevent later errors
        if (!session_id()) {
            session_start();
        }

        parent::setUpBeforeSuite();

        $container = ContainerFactory::getInstance()->getContainer();
        /** @var ShopConfiguration $shopConfiguration */
        $shopConfiguration = $container->get(ShopConfigurationDaoBridgeInterface::class)->get();

        /** @var ModuleStateService $moduleState */
        $moduleState = $container->get(ModuleStateServiceInterface::class);

        if (!Registry::getSession()->hasVariable('d3testInfoOutput')) {
            if (Registry::getConfig()->isProductiveMode()) {
                echo self::D3CLI_COLOR_YELLOW . PHP_EOL . '      - The shop should not be tested in production mode for caching reasons.'
                    . PHP_EOL . PHP_EOL . self::D3CLI_COLOR_DEFAULT;
            }
            if (false === $shopConfiguration->hasModuleConfiguration('invoicepdf') ||
                 false === $moduleState->isActive('invoicepdf', Registry::getConfig()->getShopId())
            ) {
                echo self::D3CLI_COLOR_YELLOW . PHP_EOL . '      - no OXID InvoicePdf module installed' . PHP_EOL .
                     '        Coverage report may be incomplete.' . PHP_EOL . PHP_EOL . self::D3CLI_COLOR_DEFAULT;
            }
            if (false === $shopConfiguration->hasModuleConfiguration('d3PdfDocuments') ||
                 false === $moduleState->isActive('d3PdfDocuments', Registry::getConfig()->getShopId())
            ) {
                echo self::D3CLI_COLOR_YELLOW . PHP_EOL . "      - no D3 PDF Documents module installed" . PHP_EOL .
                     "        Coverage report may be incomplete." . PHP_EOL . PHP_EOL . self::D3CLI_COLOR_DEFAULT;
            }
            foreach ([ 'd3usermanager', 'd3bonimascore' ] as $incompatibleModuleId) {
                if (true === $shopConfiguration->hasModuleConfiguration($incompatibleModuleId) &&
                     true === $moduleState->isActive($incompatibleModuleId, Registry::getConfig()->getShopId())
                ) {
                    echo self::D3CLI_COLOR_YELLOW . PHP_EOL . "      - inaccurate test results possible due to installed " .
                         'and activated "' . $incompatibleModuleId . '" module' . PHP_EOL . PHP_EOL . self::D3CLI_COLOR_DEFAULT;
                }
            }
            Registry::getSession()->setVariable('d3testInfoOutput', true);
        }
    }

    /**
     * setup basic requirements
     *
     * @throws DatabaseConnectionException
     * @throws DatabaseErrorException
     * @throws d3DicException
     */
    public function setUp(): void
    {
        parent::setUp();

        d3DicHandler::getUncompiledInstance();

        d3GetOxidDIC()->set('d3.ordermanager.log', d3GetOxidDIC()->get(d3NullLogger::class));

        Assert::that(d3_cfg_mod::get($this->sModId))->isInstanceOf(d3_cfg_mod::class);
        Assert::that(d3_cfg_mod::get($this->sModId)->getFieldData('oxserial'))->notBlank('The module license key is missing.');

        $this->_setLicenseKeyBackup(d3_cfg_mod::get($this->sModId)->getFieldData('oxserial'));
    }

    public function tearDown(): void
    {
        parent::tearDown();

        d3DicHandler::removeInstance();
    }

    /**
     * @param $sCurrKey
     */
    protected function _setLicenseKeyBackup($sCurrKey)
    {
        if (null === $this->_sCurrentLicenseKeyBackup) {
            $this->_sCurrentLicenseKeyBackup = $sCurrKey;
        }
    }

    /**
     * unvalid edition: testlicense, no feature bit set
     * @param d3ordermanager|false $oManager
     * @return d3ordermanager|null
     * @throws d3_cfg_mod_exception
     */
    protected function _setUnvalidEditionLicense($oManager = false)
    {
        return $this->_setModuleLicenseKey(
            '3Ikv2==ZDE1MnFqYXpaSWNFS09WTjdWUEdnclV0UzJnREFVZitPWG90T2RQNEJtU2x3UFFpb3BrS1Jmc
0FaTytnWnhvZVYwYVdic1RHWU00N0hlSWpCYXExWm0zRkhHeEpOTGw5d04zdVU2c25McjdkbENBV2poZ
TA2SEVnU0Q0QjVlQWFSN0ZIdG8rTTVDcUh6am8yMjQ1TkkrbDRDVEVpU0ZaNWtyK0xzb2J5RE1FalhSS
TNoMnZ5RjFVS0VCY1I0YWdNQXJCNHRMck1MeUZxc21uZXhOendQdCt2TTF2T3lKakxaMEJyRi8xVG1Cd
0hWUDQ3eW1iM2FmaWZxaDdSQUZPQlNsMjhiaEd3MnJMVGFaMFdNNEhPNS9iNGtMSWEwUGR3amVPc1RTO
Gs5YjJVWkRjZkNNaWtld3ZPd0hMRFVRaFRvanRLRlllYUZUVitrUGVPcGlKWEdWRFpxZUw1eTM3bU5Jd
25TYk4wZWw1K0UwSjFXZ1VxNzE2WnNLai9wNnJTR2pDSnpzVm11RERzNFZYVnNtaVd4YzgxdUQzYjRDa
mJyWW5qN3dXK3JmZ3Z2TEt5Ui95TFdBeGJkaEp3aXYvYWVwQTZkVUhGYlNDSldVcmUyaCtUN0RyOTVMe
XVvTDlMUExvanltckRGY0t5dFBnMm5jcThxWFdob0xaaDAwUFA3TDNZcWx6RFgxNkNEWllVdUt3ZkVSU
nVCeG9sNTZYWk83K0czOXBNbEVXRmFnelNaaExMdU1LZ085UkVhT0U2SitMM0pRVlhVcnNXVFNZQWh3T
k1rQ2ljbEF2RzBxckpTSkpDK25QODV6UlZVVEFjS0xKUlUxT1QxeUtYZ0lFaHVnNVJBangvTVQzUmdNT
GVyTTV6YmVZR0tkSW8yRysxRGN4SWJMcEl5N0tZVDJnUjZma2l0N3VjSVRXd1BtVlNuL1NRYnNGMVZsS
mVTYStkejI1UENtOFBWR3BaTGpyVDJvNEtzeElaMnRxSmlNZU5PWTUydVdVYmNHN3cweTFXUzU5aWFMa
llzTG1JOXRlTThqakxLb3BNdzBJTkE2bFJTcnlLR2JFdzZRZjRVcGcrZEpvN29BZ1dYMHBFMitWU084Q
VNRbVdQVk54UVN5Umx0RUVXTUFEY2QyVStDZ1hYaGpNL3JGUDdqQndvaFZkZFRPaSt0UmJPcnlFcUd2T
mpLdW1TVExkUWRDMlJyamhZejQ1VVdKNm1RM1RCY1R5N05Fd2phMXg0azNnQ3pKS3l3cjc4S0xnc0M4Z
DhGYWhU',
            $oManager
        );
    }

    /**
     * unvalid license: domain is mydomain.de, valid from 2000-01-01 00:00:00 to 2000-01-01 00:00:01
     * free, standard and premium edition is set
     * @param d3ordermanager|false $oManager
     * @return d3ordermanager|null
     * @throws d3_cfg_mod_exception
     */
    protected function _setUnvalidLicense($oManager = false)
    {
        return $this->_setModuleLicenseKey(
            'GsPv2==Qm1vZi8yZGg1NDc3UUhWeFdsM3FVQ3REbW91MXVzRzRUV0hOdW5XQWMwbis0RFRpRStwWDM3S
DRVaklENUdtcEU2Q2orMDVmZlJMSTlCSkRTbWJ4ckVwVGtMbkRYS2xlbVNmQUFxdk1reW04OENubW1zL
3BobDR5VW1PWldKcUY1bXhmQTZXT2ZmWXkzckNqclgwK2JxaGJZdzBUaGdYeHlPcU9DZ2dja251ZmNKU
zVWTnhxS3Z0dFJ0NVhtM20zRDFWdHBkNGJvN013VFRNUzJpZ0lXaEgxMG9BYS9iMjFqSDVySUw5YXdja
U9wbUh0SHdVWVNxem1QQUREc2drQjNaZkovZEQxYnd0Wk5PSCtWbDVDOEdObk5qWHhNTG8yR0VUMUUvQ
WJBd0dSYzFRdXBDb3pJdEZId1pCMEthcmtTR3hQSUwybW1CcGV6cnBhWFVnT3YwWG1kV3l5VnJ3aHBRN
zYyQjJ1TzFWTW56L2tSSVVmdkNDM1FvOVFnVjlKczViZWJWbC9zSGltS3lLeVFQbE4yRjBIY0dSckVSa
nJ5UTFCTkxBS0x0VHpOSGkxak45YVI2M2RWbHd6U3BKeVd4SDhQUkpTNlpmN1NYaXVqOFNmOHV6SlNEM
E5mWjRmZGRPdlh1WDVRVVBVU3RSUS9wcmxKdWxNM01SVUFlNjZ0UUpjWkhJbVJqa05MeEQ4VzBYcFpmN
kowK2JMMDMwT2pkNmtUZTU0WHRZVkZTaU5HaUdCWmtXQlVSN29LQXdlYURQRFc2N1pQUERKdlBGWXZUY
mxlS3lOZlBab3JJMjhVRVk1L2sxcG1ZWDlhMDhncmxvWUdKT3M4OTA2T1ZWbW1mNmF5RXV2UGk1YzAwR
U9oYkRQRXloU1YrbE4wQWovelY1c3B6K3BXYVJUOEE5SWFyYzF5NGtaZ0s1NVRrbEQ5MndFZmZXWmx6N
FZtOUE5SmMrR1FRT2xzd1dhUjg5SlpXcVpLVFJnd3Z1a2Q1UG85OGd2T1B3VzZCZk5iaXNwcTUyOGZ0N
E4vbDBuM2hweFBMSHpsTXF1TEZGM2NtbURiTHVmc1BqYndzRGx5ZEJHSFQ4RExMTnJIZTlKcmtDQTl2T
1BrdVZ4MW1CaDdDdG5ydzg3YjFEQ3JpUFAreTRnMlM3SHlXS3Axb0xhWC9aWTBOZ2dFNWhUbGIvSkpmU
mRPR1RuYlI4clJ3b0lZaVlnLzhVcUJqTHkzR3Z3Qmpmd2pNWGo3QnhuLzAwUC9nZVpYS1YwNFF2QktGZ
CsveXVtQmxkN2h4NWsrMXJLanBVSk5ObnFGUT09',
            $oManager
        );
    }

    /**
     * license is restricted to 1 executable job, all other restrictions are disabled
     * @param d3ordermanager|false $oManager
     * @return d3ordermanager|null
     * @throws d3_cfg_mod_exception
     */
    protected function _setJobRestrictedLicense($oManager = false)
    {
        return $this->_setModuleLicenseKey(
            'oW6v2==akxtdk1SNG16MzRKV1hvdmM3SFJ2WVpZcXV3ZThZNEVmUnNPTzkzdE54bnNod3l4UzBlZXQxN
FQvSzg0aVNDSDY2UUxDVFVHbHpiNXZwZmFiQjZOVzFZc1RRVkl2d1ZmTXZZMXEvY2FwY1JxSHAxcU5Wa
Vg1TnhLdVE2alZMdFJ6bDB6dDY0eFhXT2sxcFBIbnVhNkEvMGIvYmRPblhuWDRXU010TFdlNHFpNGU4d
npLaXF2TnN5TzBibkx5ZlBYOUxWOWp0M0k0dlAyWldDN2V0ZjBkcXdUNU53Yld6UnppQ3FEUkxGOUlNa
WVPK2YyeW5zZXJZZTJxRi9XMHRqMVVsR2xCZFNtQzdrWHZkRlZ0T3d1ZG9ramVTOVBkaExta0dyV0lKO
Ek5R0c0bWN5aHJFWWtEeDdZOWczZ1RnTElMTGVCN2IyaE85Y1hyODNWTFpEb2h3M0JCNkpCSmVLV1NZO
UtvVHIzSU9DcmN6Y29NTnlocXFTMnVmOWVNdnk3ZVNVZG1xY3JMUGh4QTVLWTllaFpKN0lkUnZGTi9PS
WxtaitFQkM4WDVMVGc0ZzlUS1Bvc25vK004NjJsSm4yV2JPYnllWkpBeHFQUVkwWGMvUDA3Wkl0Vzk0a
GQxdWJUWFlrS3FiZERPcjV4c0s4alZTY3pmQTBXcUsraElwQlRjYjNYQU1aUWZCZ3JrN3RJMGpvcGx0W
E8yZjFWTXBzbkdhQnZzOUsvVWFXSHVJeXV6emRQbVpWTXBsN0VQaGxaREhvV1owa1lxZWZielRaUWt5c
nFvOTB3MWxveXUzMjZSYVo1dWJtNUp6VHNLa1hFeXYrUzV0cFpNY1VVVmpGS3NOdWY5UmxnTENZdVZlc
zBjdkYxQmI2VW5ueG9RVFFRdlNUZzZ4czNnT2x0V1I2V21yRmVsV1phSjA1L21TRjdpdjVEWXJidkVjR
29iUmdqTkxkamdyb0RCUlYwbEVSKzhBVUhvcU1BTnZPdkxkKytnZnBWWEZRM044V1o0Q1R5eWxiWTNwZ
25EYzNaT0Z6WUZHSTZRZUhzbERLaTR1TE1oSjREUHdxak5Qam9oc3BYZjFYbjRWSStHclNZRnRQMTl2K
yttUUVxV2xYa0tUWVZTSk9zd3dhQUhMVXJTNnZRVThxTXp3eGx0dFg3UnR0U3pMZzcxdndNTXpEUXZzc
DhhM2NybWk2MEtBcWZyQWN0bnhwdElnMnlIM01CSlFvV0pnRjdFSWpwT1l0T0pENXo3aFpyWjdrNUZzc
kkxd0c2',
            $oManager
        );
    }

    /**
     * @param null $oManager
     * @return d3ordermanager|null
     * @throws d3_cfg_mod_exception
     */
    protected function _setCustomerLicense($oManager = null)
    {
        if ($this->_sCurrentLicenseKeyBackup) {
            $oReturnManager = $this->_setModuleLicenseKey($this->_sCurrentLicenseKeyBackup, $oManager);

            if ($oManager) {
                return $oReturnManager;
            }
        }

        return null;
    }

    /**
     * @param $sLicenseKey
     * @param d3ordermanager|null $oManager
     * @return d3ordermanager|null
     * @throws d3_cfg_mod_exception
     */
    abstract protected function _setModuleLicenseKey($sLicenseKey, $oManager = null);
}
