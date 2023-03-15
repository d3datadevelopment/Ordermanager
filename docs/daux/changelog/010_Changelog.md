---
title: Changelog
--- 

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://git.d3data.de/D3Private/Ordermanager/compare/5.1.1.1...rel_5.x)

## [5.1.1.1](https://git.d3data.de/D3Private/Ordermanager/compare/5.1.1.0...5.1.1.1) - 2023-03-15
### Fixed
- compatibility problem under PHP - ^8

## [5.1.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.1.0.0...5.1.1.0) - 2022-12-20
### Added
- installable in OXID 6.5.1 (CE 6.13)

## [5.1.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.4.0...5.1.0.0) - 2022-09-01
### Added
- installable in OXID 6.5 (CE 6.12) and PHP 8.1

### Changed
- adjust DI container to updated container dependency
- adjust tests

### Fixed
- prevent "undefined array key" warning

## [5.0.4.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.3.1...5.0.4.0) - 2022-08-15
### Changed
- extract message content creator from mail class

## [5.0.3.1](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.3.0...5.0.3.1) - 2022-07-28
### Changed
- make mySQL content check more compatible
- adjust documentation to Source Guardian Loader based installation
- changelog improved

### Fixed
- timespan requirement option in admin panel does not represent the saved type

## [5.0.3.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.2.0...5.0.3.0) - 2021-12-17
### Added
- installierbar in OXID 6.4.0

## [5.0.2.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.1.0...5.0.2.0) - 2021-12-02
### Added
- Platzhalter in Push Notification URLs werden nun für dynamische Parameter geparst
- zusätzliche GET Parameter werden bei POST Verwendung an den POST Body angehängt

### Changed
- Dateiregister für kommende Connector-Version angepasst
- CLI-Prüfung für PHP interne Server angepasst

### Fixed
- Type cast Fehler korrigiert

## [5.0.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/5.0.0.0...5.0.1.0) - 2021-10-01
### Added
- Templateblöcke hinzugefügt
- installierbar in OXID 6.3.1

### Changed
- #10850: Limitierung wird vorzeitig auf das Ergebnis des Filterqueries angewandt

### Fixed
- #10933: Übersicht zeigt falsche Anzahlen
- #10841: Bedingung: bei diesen Versandarten - gibt Versandkostenregeln aus
- Übersicht zeigt richtige Templatequelle der Exportaktion an
- Namen der Versandkostenregelbedingung angepasst

## [5.0.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.2.3...5.0.0.0) - 2021-04-27
### Added
- installierbar in OXID 6.3.x

### Changed
- Tests angepasst

### Fixed
- Eingabekonvertierung bei Rabatt ändern Aktion optimiert

## [4.1.2.3](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.2.2...4.1.2.3) - 2021-05-10
### Fixed
- fehlender OXID-Service im no-dev-Modus führt zu Fehlern im Modul

## [4.1.2.2](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.2.1...4.1.2.2) - 2021-05-07
### Fixed
- Warnung bei Verwendung der Standardsprache bei CLI-Aufrufen entfernt
- Fehler bei undefinierter STDOUT Konstante behoben
- Verwendung leerer Tasklisten optimiert
- Einstellungszuordnungen optimiert

## [4.1.2.1](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.2.0...4.1.2.1) - 2021-04-27
### Added
- installierbar in OXID 6.2.4

### Changed
- D3 Methoden in öffentlichen Klassen mit individuellen Namen versehen

### Fixed
- Syntaxfehler in Wochentagsbedingungsprüfung korrigiert
- erweiterte Methoden für Kompatibilität mit Elternmethoden angepasst

## [4.1.2.0](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.1.0...4.1.2.0) - 2021-03-10

** Hinweis für kleinere Versions-Upgrades: Es gibt einige rückwärts-inkompatible Änderungen an dieser Version. **

### Added
- erweiterte Konfigurationsprüfung integriert
- Ausführungsabbruch mit passenden Fehlermeldungen bei Konfigurationsfehlern eingefügt
- Debugausgaben werden auch bei Konsolenausführung gezeigt
- statische Auswahllisten sind erweiterbar
- Prüfung und Behandlung von Kompilierungsfehlern aufgrund fehlerhafter Smarty-Codes
- Abfangen leerer Inhalte auf Grund von falsch encodeten Templatedateien
- Profiling für CLI und GUI integriert
- Historyeinträge können optional angelegt werden
- globale Filter pro Shopmandant für Migrationsfälle konfigurierbar

### Changed
- Bedingungen- und Aktioneninterfaces aktualisiert
- Response-Script für automatische Ausführung als abgekündigt markiert
- Exportdateinamen wird für gültige Dateinamen überarbeitet
- Modul verwendet strict types
- Remark anlegen optimiert

### Fixed
- Bedingung "gesetzte Rechnungsnummer" korrigiert
- Endlosschleifen bei Ausführung von finalizeOrder- und orderSave-Trigger verhindert
- Ordnernamen, die nicht aus Übersetzungen kommen, zeigen keine Fehlermeldung
- nicht generierbare Statusmails korrigiert
- Debugmodus verwendet SQL-Logger für optimierte Anzeige
- nicht geladenes Manager-Objekt im Admincontroller korrigiert
- "Einträge als erledigt markieren" ignoriert "Einträge nicht als erledigt markieren"-Option 

## [4.1.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/4.1.0.0...4.1.1.0) - 2020-12-21

** Hinweis für kleinere Versions-Upgrades: Es gibt einige rückwärts-inkompatible Änderungen an dieser Version. **

### Added
- Angepasst für Shopversion 6.2.3
- Zufallspasswort wird im Installationsprozess erstellt

### Changed
- Einstellungen zu Wiedervorlage von Auslöser-Tab verschoben
- Funktionsnamen eindeutig gemacht
- D3-Logo zu statischem Assett geändert
- Cron-Task optimiert
- an Code des Kundenmanager Moduls angepasst

### Fixed
- Tests angepasst
- Kurzbeschreibungen der Aufgaben gekürzt, um Fehler in der Installation zu vermeiden
- Aufgabenbeschreibung wird nicht doppelt UTF-codiert
- Queryfehler korrigiert

## [4.1.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/4.0.0.0...4.1.0.0) - 2020-08-20
### Added
- PDF-Dokumente können optional aus D³ PDF Dokumente Modul sowie auch aus OXID PDF Invoice Modul generiert werden
- Push-Notifications können versendet werden

### Changed
- OXID Invoice PDF Modul ist keine Anforderung mehr
- jeder ausgeführte Task wird auf Abbrüche kontrolliert, um Folgetasks weiter ausführen zu können
- Inhalte der E-Mails werden in Bestellssprache geladen
- Sprachumschalter bei den Moduleinstellungen entfernt, um Verwirrungen bei unterschiedlichen Konfigurationen zu vermeiden
- Währung der Bestellung wird im Maileditor geladen, um passende Formatierung zu verwenden
- umfangreicher Setupschritt wird nur noch einmalig ausgeführt

### Fixed
- Dateinamen der PDF-Dokumente werden auf ungültige Zeichen geprüft und korrigiert
- RemarkHandler verliert Informationen beim Ausführen von Cronjobs
- ungültige Zeichen in PDF-Dateinamen werden ersetzt
- alte Cronaufrufe ohne Command starten Verarbeitung nicht

## [4.0.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.2.0.3...4.0.0.0) - 2020-04-29

** Hinweis für kleinere Versions-Upgrades: Es gibt einige rückwärts-inkompatible Änderungen an dieser Version. **

** Mit dieser Modulversion wurde das InvoicePDF-Modul aus den Anforderungen des Auftragsmanagers entfernt. Das PDF-Modul wird weitherin unterstützt, ist jedoch keine Bedingung mehr. Wenn das PDF-Modul benötigt wird, kann es mit `php composer require oxid-projects/pdf-invoice-module` wieder zur Installation hinzugefügt werden. **

### Added
- Kompatibilität zu OXID 6.2 hergestellt
- Tests vervollständigt
- Sonderzeichen in Demoprofilen werden passend dargestellt

### Changed
- InvoicePDF-Modul aus den Requirements entfernt

## [3.2.0.3](https://git.d3data.de/D3Private/Ordermanager/compare/3.2.0.2...3.2.0.3) - 2020-04-24
### Changed
- Demoprofile werden nicht pauschal im ersten Shopmandanten installiert, sondern im 1. Mandanten mit aktiviertem Modul

### Fixed
- Verwendung des Core-Tabellennamens gegen Viewnamen getauscht 
- fehlende Einträge im Fileregister nachgetragen
- exportiertes Rechnungs-/Lieferschein-PDF zeigt Logo

## [3.2.0.2](https://git.d3data.de/D3Private/Ordermanager/compare/3.2.0.1...3.2.0.2) - 2020-04-21
### Changed
- Abhängigkeit von Metapackage zu Core-Shop für Installationen ohne Metapackage geändert
- Einstellungsprüfungen für PDF-Generierung ergänzt
- zeigt nur die Anzahl der Cronjobaufgaben, die auch für Cronjobausführung aktiviert sind

### Fixed
- Dateisystem-Klassen als "nicht geteilt" markiert für Mehrfachzugriffe mit unterschiedlichen Parametern 
- QueryGenerator-Aufrufe korrigiert
- verwendet subshopabhängigen View-Tabellennamen

## [3.2.0.1](https://git.d3data.de/D3Private/Ordermanager/compare/3.2.0.0...3.2.0.1) - 2020-03-19
### Fixed
- Mails aus HTML-Vorlagen werden in der Sprache generiert, in der die Bestellung aufgegeben wurde 

## [3.2.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.1.1.0...3.2.0.0) - 2019-12-10
### Added
- bearbeitbare E-Mails haben nun einen WYSIWYG-Editor, wenn einer im Shop installiert ist
- Selectlisten sind nun alphabetisch sortiert (Payments, Deliveries, Countries, Groups)
- Mail-Editor kann aus HTML-Inhalt automatisch Plain generieren (für jeden Fall einstellbar)
- CLI-Aufrufe erfolgen nun über entsprechendes Framework -> optimiertes Handling
- Cron-Aufrufe können über ./vendor/bin/d3_ordermanager_cron gestartet werden, alte Aufrufe sind weiterhin möglich
- verkürzter Cron-Pfad wird auch im Admin gezeigt

### Changed
- Tests angepasst
- Workaround für früher fehlenden TPL-Block entfernt

### Fixed
- History-Einträge aus Mailversand verwendet manuell bearbeite Mailinhalte, wenn diese angepasst wurden
- History-Einträge werden in jeder verfügbaren Empfänger-Konstellation angelegt
- Fehler im Aufgabenfilter der Adminansicht korrigiert

## [3.1.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.1.0.0...3.1.1.0) - 2019-10-21
### Added
- Trigger-Dokumentation ergänzt
- neue Templateblöcke für die Templates der Bedingungen und Aktionen eingefügt
- PDF-Typen und PDF-Aktionen als Konstanten definiert
- UnitTests ergänzt

### Changed
- HelpCenter Link aktualisiert
- d3modprofile::oxupdate als Nicht-Multilang-Feld definiert

## [3.1.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.0.2.0...3.1.0.0) - 2019-07-08
### Added
- neue Auslöser "onOrderSave" und "onOrderFinalize"
- alle Auslöser haben eine "pre execute script"- und "post execute script"-Option (nicht in allen Moduleditionen verfügbar)
- Basisbeschreibung für jede Adminseite eingefügt
- "verfügbar für manuelle Ausführung" kann nun optional auch die erfüllten Bedingungen prüfen - Aufgabe steht bei unpassenden Bedingungen dann nicht an Bestellung zur Verfügung
- ergänzende Tests hinzugefügt

### Changed
- Adminbereich optimiert - alle Auslöser in eigenen Tab ausgelagert
- Bootstrap-Locator für zukünftige Verwendung des globalen bin-Verzeichnisses angepasst

### Fixed
- HTML-Struktur der Admin-Templates korrigiert
- zu wenig isoliert laufende Unit-Tests angepasst

## [3.0.2.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.0.1.0...3.0.2.0) - 2019-05-07
### Added
- automatisierte Tests (Unit Tests, Integration Tests) integriert
- statt absoluter Instanzdefinition werden DIC Services verwendet

## [3.0.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/3.0.1.0...3.0.0.0) - 2019-02-27
### Added
- beim Speichern der Aktionen wird auf unzureichend ausgefüllte Werte hingewiesen
- beim Speichern der Bedingungen wird auf unzureichend ausgefüllte Werte hingewiesen

## [3.0.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.4.0...3.0.0.0) - 2017-12-15

**Minor version upgrade notice: there are some backward-incompatible changes to this release.**

### Added
- Installation via Composer

### Changed
- für OXID6 umgearbeitet
- Dezimalangaben in Einstellungen werden auch mit Komma richtig verarbeitet
- Exporttemplates können aus einstellbaren Pfaden geholt werden

## [2.3.4.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.3.0...2.3.4.0) - 2017-05-19
- Admin-Layout für Shopversion 4.10/5.3 optimiert
- Menü-Icon hinzugefügt
- Seitentitel optimiert
- Hintergrund-Logo entfernt
- Apache 2.4-Kompatibilität eingefügt
- veraltetet Methodenaufrufe ersetzt
- changed_full-Inhalte entfernt

## [2.3.3.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.2.1...2.3.3.0) - 2016-03-14
- "gefundene Bestellungen ohne Bearbeitung als erledigt markieren"-Funktion eingefügt
- Bedingungen "Prüfung des Ausführungsstatus einer anderen Aufgabe" eingefügt
- Installation konvertiert Beispiele nach UTF8
- Zeitstempel-Ersetzung optimiert
- Dokumentation überarbeitet
- Installationsscript verschoben

## [2.3.2.1](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.2.0...2.3.2.1) - 2015-03-25
- PDF-Generierung verwendet Sprachbausteine aus Adminbereich
- Performance: Statistikabfragen optimiert
- Performance: Statistikauswertungen können einzeln abgefragt werden
- Installation: nicht mehrsprachige Datenfelder werden bei Konvertierung von Alteinträgen nur einsprachig übertragen
- Rechnungsdatum wird nicht vordatiert
- Format des Rechnungsdatums angepasst
- E-Mail CMS Text wird in Sprache der Bestellung ausgeliefert

## [2.3.2.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.1.0...2.3.2.0) - 2015-01-16
- Maildaten werden aus Bestellung bezogen, wenn Kundenkonto nicht mehr verfügbar ist
- Optimierung für Multilang-Tabellen integriert
- zu bearbeitende Bestellung wird separat (außerhalb der orderlist) geladen, sind sonst unvollständig
- einzelne Modprofile-Felder von Multilang-Speicherung ausgeschlossen, da Aufgaben nicht sprachabhängig ausgeführt werden können
- Artikelselektion nach Kategorie ist nun auch auf Variantenartikel anwendbar, die selbst keiner Kategorie zugeordnet sind
- Prüfung auf unregistrierte Dateien eingefügt

## [2.3.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.3.0.0...2.3.1.0) - 2014-12-09
- SH-Generator integriert
- fehlende Kompatibilität für OXID 4.7.x nachgerüstet
- Cronjob-ID für Shellaufrufe nachgetragen
- Warenkorb-Handling für Mailversand optimiert

## [2.3.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.1.1.0...2.3.0.0) - 2014-11-13
- OXID 4.9 / 5.2 Installationsanweisungen eingefügt
- Cronjob-ID für gezieltere Aufgabenaufrufe integriert
- Remark- und Info-Handling optimiert
- alternative From- und Reply-Adresse in Mailsendeaktion integriert
- Templatequelle für Mailsendeaktion kann nun auch ein Modulverzeichnis sein
- Templatestruktur bereinigt

## [2.1.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.1.0.1...2.1.1.0) - 2014-07-23
- bei nicht ausführbaren Bedingungen / Aktionen wird Protokoll-Eintrag geschrieben
- Performance-Verbesserungen integriert

## [2.1.0.1](https://git.d3data.de/D3Private/Ordermanager/compare/2.1.0.0...2.1.0.1) - 2014-05-21
- "Auftrag manuell ausführbar"-Option korrigiert
- Cronjob-Hinweise werden zusätzlich im Browser ausgegeben

## [2.1.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/2.0.0.0...2.1.0.0) - 2014-05-06
- Verwendung von allgemeinen Modulprofilen anstatt eigener Profile
- Listenexport eingefügt
- Individualmethoden eingefügt
- neues Lizenzschema umgesetzt

## [2.0.0.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.5.0...2.0.0.0) - 2013-03-21

**Minor version upgrade notice: there are some backward-incompatible changes to this release.**

- Anpassung auf OXID 4.7.X / 5.0.X
- Generieren von PDF-Dateien

## [1.5.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.4.0...1.5.0) - 2014-07-09

## [1.4.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.3.0...1.4.0) - 2014-07-01

## [1.3.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.2.0...1.3.0) - 2012-08-08
- Mailsubject wird aus Template generiert
- Bestelldaten enthalten optional auch stornierte Artikel
- Prüfung auf leere Bestelleinträge möglich
- fehlende "isBundle"-Methode in alten Shopversionen berücksichtigt
- Mailtemplates können aus Frontend- oder Backend-Theme geholt werden
- Benutzerinformationen werden aus Bestelldaten verwendet (nicht von User-Daten)

## [1.2.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.2.0...1.3.0) - 2012-06-22
- EE-Multishop-Funktionalität
- Cronjob verwendet "Aktiv"-Flag
- Hook für Mailprogrammierungen eingefügt
- Smarty-Variablen für Verwendung der originalen Bestellbestätigungsmails vervollständigt

## [1.1.0](https://git.d3data.de/D3Private/Ordermanager/compare/1.1.0...1.2.0) - 2012-03-19
- Mailvariablen hingefügt
- Templates auf 4.5.11 geprüft

## [1.0.0](https://git.d3data.de/D3Private/Ordermanager/releases/tag/1.0.0) - 2012-01-29