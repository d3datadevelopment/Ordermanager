---
title: Auslöser
---

Hier stellen Sie ein, wann und wie die Augabe gestartet werden kann.

Sie haben die Wahl zwischen:

- zeitgesteuerter Cronjob

  Lassen Sie die Aufgabe immer zu vorab festgelegten Zeiten starten. Sie müssen sich dann um die Ausführung nicht kümmern.

  Der [ automatische Auführung über Cronjob möglich ]-Haken definiert, ob diese Aufgabe über die Cronjobs ausgeführt werden darf. 

  Der Einstellung der Cronjob-ID widmet sich das Kapitel [Cronjobs für unterschiedlich zu steuernde Aufgaben](../060_Cronjobs_fuer_unterschiedlich_zu_steuernde_Aufgaben.md) ausführlich.

  > [i] Beachten Sie bitte, das zusätzlich zu diesen Einstellungen ein passender Cronjob auf Ihrem Server eingerichtet sein muss. Der Ablauf der Einrichtung ist von Ihrem Provider abhängig. Bei Fragen kontaktieren Sie bitte uns oder Ihren Provider.

- manuelle Ausführung

  Alle Aufgaben können auch manuell für jede Bestellung ausgeführt werden. Ob dies für die Aufgabe sinnvoll erscheint, können Sie mit dem Haken [ manuelle Ausführung an Bestellung möglich ] festlegen. Haben Sie den Haken gesetzt, wird diese Aufgabe an den Bestellungen (im Admin unter [ Bestellungen verwalten ] -> [ Bestellungen ] -> [ D3 Auftragsmanager ]) angezeigt. (siehe auch [Aufgaben manuell ausführen](../070_Aufgaben_fuer_alle_relevanten_Bestellungen_manuell_ausfuehren.md)).
  
  Mit "Aufgabe wird nur bei Bestellungen angeboten, bei denen die eingestellten Bedingungen erfüllt sind" können Sie entscheiden, ob die Aufgabe an jeder Bestellung angezeigt werden soll oder nur an Bestellungen, die die eingestellten Bedingungen erfüllen.

- nach dem Abschluss der Bestellung durch den Kunden

  Die Aufgabe wird dann ausgeführt, wenn der Kunde seine Bestellung im Bestellschritt 4 abgesendet hat und diese vom angelegt wurde. Die Aufgabe führt dann nur diese eine Bestellung aus, wenn diese die eingestellten Bedingungen erfüllt.
  
  > [i] Technisch gesehen erfolgt die Bearbeitung der Bestellung nach Ausführung von \OxidEsales\Eshop\Application\Model\Order::finalizeOrder()
  
- nach jedem Speichern der Bestellung

  Die Ausführung der Aufgabe erfolgt immer dann, wenn eine Bestellung gespeichert wird. Je nachdem, ob die bearbeitet Bestellung als "erledigt" markiert wird, erfolgt (k)eine erneute Bearbeitung beim nächsten Speichern.
  
  Dieser Auslöser und der Auslöser "nach dem Abschluss der Bestellung durch den Kunden" überschneiden sich thematisch, da beim Abschluss der Bestellung diese ebenfalls gespeichert wird. Eine gleichzeitige Aktivierung dieser beiden Auslöser ergibt i.d.R. keinen Sinn.
  
  > [i] Technisch gesehen erfolgt die Bearbeitung der Bestellung nach Ausführung von \OxidEsales\Eshop\Application\Model\Order::save()

Aktive Auslöser werden für die schnelle Übersicht mit einen grünen Häkchen markiert.

An jedem Auslöser können Sie die Ausführung einer Vorabsriptes und / oder eines Danachscriptes einstellen, welches vorbereitende oder nachbereitende Arbeiten ausführt (nur verfügbar in der [Premium-Edition](../../editions/010_Editionen.md).

Speichern Sie gesetzte Einstellungen ab.
