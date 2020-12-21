[{oxmultilang ident="D3_ORDERMANAGER_MAIL_OMJFROM"}] [{$smarty.now|date_format:"%d.%m.%Y %H:%I"}]
  
[{foreach from=$aNotes item="aManagerJobs" key="sOrderId"}]
[{assign var="oItem" value=$oEmailView->d3getOrder($sOrderId)}]
[{if $oItem->getId()}][{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDER"}] [{$oItem->getFieldData('oxordernr')}] [{oxmultilang ident="D3_ORDERMANAGER_MAIL_ORDERFROM"}] [{$oItem->getFieldData('oxorderdate')}] ([{$oItem->getFieldData('oxbilllname')}], [{$oItem->getFieldData('oxbillfname')}])[{else}][{oxmultilang ident="D3_ORDERMANAGER_MAIL_GENERAL"}][{/if}]:
[{foreach from=$aManagerJobs item="aJobActions" key="sManagerId"}]
[{assign var="oManager" value=$oEmailView->d3getOrderManager($sManagerId)}]
    [{$oManager->getFieldData('oxtitle')}]
[{foreach from=$aJobActions item="sJobText"}]
    [{$sJobText}]
[{/foreach}]
[{/foreach}]
[{/foreach}]
