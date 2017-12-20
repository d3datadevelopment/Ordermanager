[{block name="d3ordermanager_infomail_main"}]
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
  <head>
    <title>[{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDERSUBJECT"}]</title>
    <meta http-equiv="Content-Type" content="text/html; charset=[{$oEmailView->getCharset()}]">
  </head>
  <body bgcolor="#FFFFFF" link="#355222" alink="#355222" vlink="#355222" style="font-family: Verdana, Geneva, Arial, Helvetica, sans-serif; font-size: 10px;">
    [{oxmultilang ident="D3_ORDERMANAGER_MAIL_OMJFROM"}] [{$smarty.now|date_format:"%d.%m.%Y %H:%I"}]
  
  [{strip}]
    [{foreach from=$aNotes item="aManagerJobs" key="sOrderId"}]
        [{block name="d3ordermanager_infomail_order"}]
            [{assign var="oOrder" value=$oEmailView->d3getOrder($sOrderId)}]
            [{if $oOrder->getId()}]
                [{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDER"}] [{$oOrder->getFieldData('oxordernr')}] [{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDERFROM"}] [{$oOrder->getFieldData('oxorderdate')}] ([{$oOrder->getFieldData('oxbilllname')}], [{$oOrder->getFieldData('oxbillfname')}]):<br>
            [{else}]
                [{oxmultilang ident="D3_ORDERMANAGER_MAIL_GENERAL"}]:<br>
            [{/if}]
            <ul>
                [{block name="d3ordermanager_infomail_manager"}]
                    [{foreach from=$aManagerJobs item="aJobActions" key="sManagerId"}]
                        [{assign var="oOrderManager" value=$oEmailView->d3getOrderManager($sManagerId)}]
                        <li>
                            [{$oOrderManager->getFieldData('oxtitle')}]
                            <ul>
                                [{block name="d3ordermanager_infomail_job"}]
                                    [{foreach from=$aJobActions item="sJobText"}]
                                        <li>
                                            [{$sJobText}]
                                        </li>
                                    [{/foreach}]
                                [{/block}]
                            </ul>
                        </li>
                    [{/foreach}]
                [{/block}]
            </ul>
        [{/block}]
    [{/foreach}]
  [{/strip}]

  </body>
</html>
[{/block}]