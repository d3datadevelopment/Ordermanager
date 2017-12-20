# Changelog
All notable changes to this project will be documented in this file.

## Unreleased

## 3.0.0.0 (2017-12-15)
### Added
- Installation via Composer

### Changed
- für OXID6 umgearbeitet
- Dezimalangaben in Einstellungen werden auch mit Komma richtig verarbeitet
- Exporttemplates können aus einstellbaren Pfaden geholt werden

## [2.3.4.0] (2017-05-19)
- Admin-Layout für Shopversion 4.10/5.3 optimiert
- Menü-Icon hinzugefügt
- Seitentitel optimiert
- Hintergrund-Logo entfernt
- Apache 2.4-Kompatibilität eingefügt
- veraltetet Methodenaufrufe ersetzt
- changed_full-Inhalte entfernt

## [2.3.3.0] (2016-03-14)
- "gefundene Bestellungen ohne Bearbeitung als erledigt markieren"-Funktion eingefügt
- Bedingungen "Prüfung des Ausführungsstatus einer anderen Aufgabe" eingefügt
- Installation konvertiert Beispiele nach UTF8
- Zeitstempel-Ersetzung optimiert
- Dokumentation überarbeitet
- Installationsscript verschoben

## [2.3.2.1] (2015-03-25)
- PDF-Generierung verwendet Sprachbausteine aus Adminbereich
- Performance: Statistikabfragen optimiert
- Performance: Statistikauswertungen können einzeln abgefragt werden
- Installation: nicht mehrsprachige Datenfelder werden bei Konvertierung von Alteinträgen nur einsprachig übertragen
- Rechnungsdatum wird nicht vordatiert
- Format des Rechnungsdatums angepasst
- E-Mail CMS Text wird in Sprache der Bestellung ausgeliefert

## [2.3.2.0] (2015-01-16)
- Maildaten werden aus Bestellung bezogen, wenn Kundenkonto nicht mehr verfügbar ist
- Optimierung für Multilang-Tabellen integriert
- zu bearbeitende Bestellung wird separat (außerhalb der orderlist) geladen, sind sonst unvollständig
- einzelne Modprofile-Felder von Multilang-Speicherung ausgeschlossen, da Aufgaben nicht sprachabhängig ausgeführt werden können
- Artikelselektion nach Kategorie ist nun auch auf Variantenartikel anwendbar, die selbst keiner Kategorie zugeordnet sind
- Prüfung auf unregistrierte Dateien eingefügt

## [2.3.1.0] (2014-12-09)
- SH-Generator integriert
- fehlende Kompatibilität für OXID 4.7.x nachgerüstet
- Cronjob-ID für Shellaufrufe nachgetragen
- Warenkorb-Handling für Mailversand optimiert

## [2.3.0.0] (2014-11-13)
- OXID 4.9 / 5.2 Installationsanweisungen eingefügt
- Cronjob-ID für gezieltere Aufgabenaufrufe integriert
- Remark- und Info-Handling optimiert
- alternative From- und Reply-Adresse in Mailsendeaktion integriert
- Templatequelle für Mailsendeaktion kann nun auch ein Modulverzeichnis sein
- Templatestruktur bereinigt

## [2.1.1.0] (2014-07-23)
- bei nicht ausführbaren Bedingungen / Aktionen wird Protokoll-Eintrag geschrieben
- Performance-Verbesserungen integriert

## 1.5.0 (2014-07-09)

## 1.4.0 (2014-07-01)

## [2.1.0.1] (2014-05-21)
- "Auftrag manuell ausführbar"-Option korrigiert
- Cronjob-Hinweise werden zusätzlich im Browser ausgegeben

## [2.1.0.0] (2014-05-06)
- Verwendung von allgemeinen Modulprofilen anstatt eigener Profile
- Listenexport eingefügt
- Individualmethoden eingefügt
- neues Lizenzschema umgesetzt

## 2.0.0.0 (2013-03-21)
- Anpassung auf OXID 4.7.X / 5.0.X
- Generieren von PDF-Dateien


## 1.3.0 (2012-08-08)
- Mailsubject wird aus Template generiert
- Bestelldaten enthalten optional auch stornierte Artikel
- Prüfung auf leere Bestelleinträge möglich
- fehlende "isBundle"-Methode in alten Shopversionen berücksichtigt
- Mailtemplates können aus Frontend- oder Backend-Theme geholt werden
- Benutzerinformationen werden aus Bestelldaten verwendet (nicht von User-Daten)

## 1.2.0 (2012-06-22)
- EE-Multishop-Funktionalität
- Cronjob verwendet "Aktiv"-Flag
- Hook für Mailprogrammierungen eingefügt
- Smarty-Variablen für Verwendung der originalen Bestellbestätigungsmails vervollständigt

## 1.1.0 (2012-03-19)
- Mailvariablen hingefügt
- Templates auf 4.5.11 geprüft

## 1.1.0 (2012-01-29)

[2.3.4.0]: https://blog.oxidmodule.com/archives/651-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.3.4.0.html
[2.3.3.0]: https://blog.oxidmodule.com/archives/589-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.3.3.0.html
[2.3.2.1]: https://blog.oxidmodule.com/archives/504-Neuer-Patch-fuer-Modul-Auftragsmanager-auf-Version-2.3.2.1.html
[2.3.2.0]: https://blog.oxidmodule.com/archives/493-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.3.2.0.html
[2.3.1.0]: https://blog.oxidmodule.com/archives/488-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.3.1.0.html
[2.3.0.0]: https://blog.oxidmodule.com/archives/476-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.3.0.0.html
[2.1.1.0]: https://blog.oxidmodule.com/archives/431-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.1.1.0.html
[2.1.0.1]: https://blog.oxidmodule.com/archives/414-Neuer-Patch-fuer-Modul-Auftragsmanager-auf-Version-2.1.0.1.html
[2.1.0.0]: https://blog.oxidmodule.com/archives/411-Neues-Update-fuer-Modul-Auftragsmanager-auf-Version-2.1.0.0.html