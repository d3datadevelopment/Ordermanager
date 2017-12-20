# Changelog
All notable changes to this project will be documented in this file.

## Unreleased

## 3.0.0.0 (2017-12-15)
### Added
- Installation via Composer

### Changed
- f�r OXID6 umgearbeitet
- Dezimalangaben in Einstellungen werden auch mit Komma richtig verarbeitet
- Exporttemplates k�nnen aus einstellbaren Pfaden geholt werden

## [2.3.4.0] (2017-05-19)
- Admin-Layout f�r Shopversion 4.10/5.3 optimiert
- Men�-Icon hinzugef�gt
- Seitentitel optimiert
- Hintergrund-Logo entfernt
- Apache 2.4-Kompatibilit�t eingef�gt
- veraltetet Methodenaufrufe ersetzt
- changed_full-Inhalte entfernt

## [2.3.3.0] (2016-03-14)
- "gefundene Bestellungen ohne Bearbeitung als erledigt markieren"-Funktion eingef�gt
- Bedingungen "Pr�fung des Ausf�hrungsstatus einer anderen Aufgabe" eingef�gt
- Installation konvertiert Beispiele nach UTF8
- Zeitstempel-Ersetzung optimiert
- Dokumentation �berarbeitet
- Installationsscript verschoben

## [2.3.2.1] (2015-03-25)
- PDF-Generierung verwendet Sprachbausteine aus Adminbereich
- Performance: Statistikabfragen optimiert
- Performance: Statistikauswertungen k�nnen einzeln abgefragt werden
- Installation: nicht mehrsprachige Datenfelder werden bei Konvertierung von Alteintr�gen nur einsprachig �bertragen
- Rechnungsdatum wird nicht vordatiert
- Format des Rechnungsdatums angepasst
- E-Mail CMS Text wird in Sprache der Bestellung ausgeliefert

## [2.3.2.0] (2015-01-16)
- Maildaten werden aus Bestellung bezogen, wenn Kundenkonto nicht mehr verf�gbar ist
- Optimierung f�r Multilang-Tabellen integriert
- zu bearbeitende Bestellung wird separat (au�erhalb der orderlist) geladen, sind sonst unvollst�ndig
- einzelne Modprofile-Felder von Multilang-Speicherung ausgeschlossen, da Aufgaben nicht sprachabh�ngig ausgef�hrt werden k�nnen
- Artikelselektion nach Kategorie ist nun auch auf Variantenartikel anwendbar, die selbst keiner Kategorie zugeordnet sind
- Pr�fung auf unregistrierte Dateien eingef�gt

## [2.3.1.0] (2014-12-09)
- SH-Generator integriert
- fehlende Kompatibilit�t f�r OXID 4.7.x nachger�stet
- Cronjob-ID f�r Shellaufrufe nachgetragen
- Warenkorb-Handling f�r Mailversand optimiert

## [2.3.0.0] (2014-11-13)
- OXID 4.9 / 5.2 Installationsanweisungen eingef�gt
- Cronjob-ID f�r gezieltere Aufgabenaufrufe integriert
- Remark- und Info-Handling optimiert
- alternative From- und Reply-Adresse in Mailsendeaktion integriert
- Templatequelle f�r Mailsendeaktion kann nun auch ein Modulverzeichnis sein
- Templatestruktur bereinigt

## [2.1.1.0] (2014-07-23)
- bei nicht ausf�hrbaren Bedingungen / Aktionen wird Protokoll-Eintrag geschrieben
- Performance-Verbesserungen integriert

## 1.5.0 (2014-07-09)

## 1.4.0 (2014-07-01)

## [2.1.0.1] (2014-05-21)
- "Auftrag manuell ausf�hrbar"-Option korrigiert
- Cronjob-Hinweise werden zus�tzlich im Browser ausgegeben

## [2.1.0.0] (2014-05-06)
- Verwendung von allgemeinen Modulprofilen anstatt eigener Profile
- Listenexport eingef�gt
- Individualmethoden eingef�gt
- neues Lizenzschema umgesetzt

## 2.0.0.0 (2013-03-21)
- Anpassung auf OXID 4.7.X / 5.0.X
- Generieren von PDF-Dateien


## 1.3.0 (2012-08-08)
- Mailsubject wird aus Template generiert
- Bestelldaten enthalten optional auch stornierte Artikel
- Pr�fung auf leere Bestelleintr�ge m�glich
- fehlende "isBundle"-Methode in alten Shopversionen ber�cksichtigt
- Mailtemplates k�nnen aus Frontend- oder Backend-Theme geholt werden
- Benutzerinformationen werden aus Bestelldaten verwendet (nicht von User-Daten)

## 1.2.0 (2012-06-22)
- EE-Multishop-Funktionalit�t
- Cronjob verwendet "Aktiv"-Flag
- Hook f�r Mailprogrammierungen eingef�gt
- Smarty-Variablen f�r Verwendung der originalen Bestellbest�tigungsmails vervollst�ndigt

## 1.1.0 (2012-03-19)
- Mailvariablen hingef�gt
- Templates auf 4.5.11 gepr�ft

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