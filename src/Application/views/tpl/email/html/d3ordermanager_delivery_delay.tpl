[{include file="email/html/header.tpl" title=$oShop->oxshops__oxname->value}]

verf&uuml;gbare Variablen:<br>
- Shop:       $oShop<br>
- Bestellung: $oOrder<br>
- Kunde:      $oUser<br>

Hallo [{$oOrder->oxorder__oxbillsal->value|oxmultilangsal}] [{$oOrder->oxorder__oxbilllname->getRawValue()}],<br>
<br>
wegen Lieferschwierigkeiten unserer Lieferanten wird sich die Zustellung Ihrer Bestellung [{$oOrder->oxorder__oxordernr->getRawValue()}]
leider um ca. 1 Woche verz&ouml;gern. Wir bitten um Ihr Verst&auml;ndnis.<br>
<br>
Ihr [{$oShop->oxshops__oxname->getRawValue() }]-Team.

[{include file="email/html/footer.tpl"}]
