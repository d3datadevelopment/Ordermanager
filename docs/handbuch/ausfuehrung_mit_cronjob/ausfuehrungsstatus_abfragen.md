# Ausführungsstatus abfragen

* für eine manuell ausführbare Aufgabe an einer Bestellung
  Wechseln Sie dazu im Adminbereich unter [ Bestellungen verwalten ] -> [ Bestellungen ] -> [ Auftragsmanager ]. Am jeweiligen Eintrag sehen Sie ein Ausführungsdatum.
* für eine Aufgabe (manuell oder automatisch ausgeführt)
  Rufen Sie die Aufgabenliste auf. Im Stamm-Tab der Aufgabe sehen Sie das Datum der letzten erfolgreich abgeschlossenen Ausführung
* für eine Cronjob-ID
  Im Backendbereich des Auftragsmanagermodul unter [ Einstellungen ] -> [ Grundeinstellungen ] öffnen Sie bitte das Klappmenü der jeweiligen Cronjob-ID. Dort sehen Sie den Zeitpunkt der letzten erfolgreich abgeschlossenen Ausführung.

## regelmäßig wiederkehrende Auswertungen

Im Normalfall erledigt das Auftragsmanagermodul seine übertragenen Aufgaben unauffällig im Hintergrund. Um sich einen Überblick über dessen Bearbeitungsstände zu verschaffen, können Sie sich regelmäßig per Mail darüber informieren lassen:

Richten Sie dazu bitte einen Cronjob im gewünschten Interval ein (z.B. jeden Monatsanfang), mit einem der folgenden Scriptaufrufe ein und lassen sich die Ausgaben einfach per Mail zusenden. Für die Abfragen stehen Ihnen derzeit folgende Aufrufe zur Verfügung:

### Übersicht über den Bearbeitungsstand aller automatisch ausführbaren Aufgaben

bestehend aus einer Liste der Namen aller Aufgaben, dem letzten Ausführungsdatum, der Anzahl der bearbeiten Bestellungen aus dem Vormonat und (zum Vergleich) aus dem vorletzten Monat sowie die prozentuale Veränderung zwischen den beiden Zeiträumen.

```
./vendor/bin/oe-console d3:ordermanager:statistic [shop-id]
```

### Anzahl aktiver Aufgaben und letztes Ausführungsdatum zu einer bestimmten Cronjob-ID

```
./vendor/bin/oe-console d3:ordermanager:status [shop-id] [cronjob-id]
```
