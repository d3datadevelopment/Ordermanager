verfuegbare Variablen:
- Shop:       $oShop
- Bestellung: $oOrder
- Kunde:      $oUser

Hallo [{$oOrder->oxorder__oxbillsal->value|oxmultilangsal}] [{$oOrder->oxorder__oxbilllname->getRawValue()}],

wegen Lieferschwierigkeiten unserer Lieferanten wird sich die Zustellung Ihrer Bestellung [{$oOrder->oxorder__oxordernr->getRawValue()}] leider um ca. 1 Woche verzoegern. Wir bitten um Ihr Verstaendnis.

Ihr [{$oShop->oxshops__oxname->getRawValue()}]-Team.

[{oxcontent ident="oxemailfooterplain"}]