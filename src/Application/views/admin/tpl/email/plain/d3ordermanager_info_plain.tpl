[{oxmultilang ident="D3_ORDERMANAGER_MAIL_OMJFROM"}] [{$smarty.now|date_format:"%d.%m.%Y %H:%I"}]
  
[{foreach from=$aNotes item="aManagerJobs" key="sOrderId"}]
[{assign var="oOrder" value=$oEmailView->d3getOrder($sOrderId)}]
[{if $oOrder->getId()}][{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDER"}] [{$oOrder->getFieldData('oxordernr')}] [{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDERFROM"}] [{$oOrder->getFieldData('oxorderdate')}] ([{$oOrder->getFieldData('oxbilllname')}], [{$oOrder->getFieldData('oxbillfname')}])[{else}][{oxmultilang ident="D3_ORDERMANAGER_MAIL_GENERAL"}][{/if}]:
[{foreach from=$aManagerJobs item="aJobActions" key="sManagerId"}]
[{assign var="oOrderManager" value=$oEmailView->d3getOrderManager($sManagerId)}]
    [{$oOrderManager->getFieldData('oxtitle')}]
[{foreach from=$aJobActions item="sJobText"}]
        [{$sJobText}]
[{/foreach}]
[{/foreach}]
[{/foreach}]
