<?php

/**
 * This Software is the property of Data Development and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * https://www.d3data.de
 *
 * @copyright (C) D3 Data Development (Inh. Thomas Dartsch)
 * @author    D3 Data Development - Daniel Seifert <support@shopmodule.com>
 * @link      https://www.oxidmodule.com
 */

declare(strict_types=1);

namespace D3\Ordermanager\tests\unit\Modules\Application\Model;

use D3\ModCfg\Application\Model\d3database;
use D3\Ordermanager\Application\Model\d3ordermanager;
use D3\Ordermanager\Modules\Application\Model\d3_oxbasketitem_ordermanager;
use D3\Ordermanager\tests\unit\d3OrdermanagerUnitTestCase;
use Doctrine\DBAL\DBALException;
use Exception;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\BasketItem;
use OxidEsales\Eshop\Application\Model\OrderArticle;
use OxidEsales\Eshop\Core\Exception\ArticleException;
use OxidEsales\Eshop\Core\Exception\ArticleInputException;
use OxidEsales\Eshop\Core\Exception\DatabaseConnectionException;
use OxidEsales\Eshop\Core\Exception\DatabaseErrorException;
use OxidEsales\Eshop\Core\Exception\NoArticleException;
use ReflectionException;

class d3_oxbasketitem_ordermanagerTest extends d3OrdermanagerUnitTestCase
{
    /** @var d3_oxbasketitem_ordermanager */
    protected $_oModel;

    /**
     * setup basic requirements
     * @throws DatabaseConnectionException
     * @throws DBALException
     * @throws DatabaseErrorException
     * @throws Exception
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->_oModel = d3GetModCfgDIC()->get('d3ox.ordermanager.'.BasketItem::class);
    }

    public function tearDown(): void
    {
        parent::tearDown();

        unset($this->_oModel);
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasketitem_ordermanager::d3OrderManagerChangeOrderArticle2RealArticle
     * @test
     * @throws ArticleException
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws ReflectionException
     * @throws Exception
     */
    public function orderArticlesCanConvertedToArticles()
    {
        /** @var Article $oArticle */
        $oArticle = d3GetModCfgDIC()->get('d3ox.ordermanager.'.Article::class);
        $qb = d3database::getInstance()->getQueryBuilder();
        $qb->select('oxid')
            ->from($oArticle->getViewName())
            ->where(1);

        $sOXID = $qb->execute()->fetchColumn();

        if ($sOXID) {
            /** @var OrderArticle $oOrderArticle */
            $oOrderArticle = d3GetModCfgDIC()->get('d3ox.ordermanager.'.OrderArticle::class);
            $oOrderArticle->assign(
                [
                    'oxartid' => $sOXID,
                ]
            );

            $this->setValue($this->_oModel, '_oArticle', $oOrderArticle);
            $this->callMethod($this->_oModel, 'd3OrderManagerChangeOrderArticle2RealArticle');
            $this->assertInstanceOf(Article::class, $this->_oModel->getArticle());
        } else {
            $this->markTestSkipped('no article available');
        }
    }

    /**
     * @covers \D3\Ordermanager\Modules\Application\Model\d3_oxbasketitem_ordermanager::d3OrderManagerChangeOrderArticle2RealArticle
     * @test
     * @throws ArticleException
     * @throws ArticleInputException
     * @throws NoArticleException
     * @throws ReflectionException
     * @throws Exception
     */
    public function orderArticlesCantConvertedToArticles()
    {
        /** @var OrderArticle $oOrderArticle */
        $oOrderArticle = d3GetModCfgDIC()->get('d3ox.ordermanager.'.OrderArticle::class);
        $oOrderArticle->assign(
            [
                'oxartid' => 'foobar',
            ]
        );

        $articleMock = $this->getMockBuilder(Article::class)
            ->onlyMethods(['exists'])
            ->getMock();
        $articleMock->method('exists')->willReturn(false);
        d3GetModCfgDIC()->set('d3ox.ordermanager.'.Article::class, $articleMock);

        $this->setValue($this->_oModel, '_oArticle', $oOrderArticle);
        $this->callMethod($this->_oModel, 'd3OrderManagerChangeOrderArticle2RealArticle');
        $this->assertInstanceOf(OrderArticle::class, $this->_oModel->getArticle());
    }

    /**
     * @param $sLicenseKey
     * @param d3ordermanager $oManager
     * @return null
     */
    protected function _setModuleLicenseKey($sLicenseKey, $oManager = null)
    {
        return null;
    }
}
