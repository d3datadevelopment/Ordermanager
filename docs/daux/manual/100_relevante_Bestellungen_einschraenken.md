---
title: Bestellungen mit globaler Einstellung einschränken
---

Neben den aufgabenspezifischen Bedingungen können die Bestellungen auch global eingestellt werden. Das kann sinnvoll sein, wenn z.B. in einem Entwicklungsshop nur alle Bestellungen ab einem bestimmten Datum oder einer bestimmten Bestellnummer verarbeitet werden sollen.

Seiten Sie dann in der Datei `config.inc.php` den folgenden Eintrag:

```
$this->d3OrderManagerBasicRestrictions = array(
    '[shopId]'  => array(
        '[feldname_1]'     => '[feldwert_1]',
        '[feldname_2]'     => '[feldwert_2]'
);
```

Als 1. Indexname geben Sie die ID des Shopmandanten, als 2. Indexname das zu filternde Feld der Datenbanktabelle `oxorder` an. Der dahinter stehende Wert ist die Einstellung, bis zu der Bestellungen ignoriert werden. In diesem Fall werden nur Bestellungen ab dem Jahr 2020 sowie mit Bestellnummer höher als 12 berücksichtigt.
Alle Einträge werden mit UND verknüpft, müssen also gleichzeitig gültig sein. Sie können Einträge für mehrere Shops und mehrere Felder konfigurieren.

Beispiel:

```
$this->d3OrderManagerBasicRestrictions = array(
    '1' => array(
        'oxordernr'     => '12',
        'oxorderdate'   => '2019-12-31'
    )
);
```

Bitte achten Sie darauf, ein gültiges Feld der `oxorder`-Tabelle anzugeben. Verwenden Sie dafür bitte kein Sprachpräfix.
