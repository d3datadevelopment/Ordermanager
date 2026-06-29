# Auslöser

!!! info "Pfad im Adminbereich"
    [ (D3) Module ] -> [ Auftragsmanager ] -> [ Aufgaben ] -> [ Auslöser ]

Hier stellen Sie ein, wann und wie die Aufgabe gestartet werden kann.

Welche Auslöser Ihnen zur Verfügung stehen, hängt von der eingesetzten Modul-Edition ab. Eine Übersicht dazu finden Sie im Kapitel [Editionen](../../../editionen.md).

Sie haben die Wahl zwischen:

- zeitgesteuerter Cronjob

  Lassen Sie die Aufgabe immer zu vorab festgelegten Zeiten starten. Sie müssen sich dann um die Ausführung nicht 
  kümmern.

  Der [ automatische Ausführung über Cronjob möglich ]-Haken definiert, ob diese Aufgabe über die Cronjobs ausgeführt 
  werden darf. 

  Der Einstellung der Cronjob-ID widmet sich das Kapitel [Cronjobs für unterschiedlich zu steuernde Aufgaben](../../ausfuehrung_mit_cronjob/cronjobs_fuer_unterschiedlich_zu_steuernde_aufgaben.md) ausführlich.

!!! note
    Beachten Sie bitte, dass zusätzlich zu diesen Einstellungen ein passender Cronjob auf Ihrem Server eingerichtet sein 
    muss. Der Ablauf der Einrichtung ist von Ihrem Provider abhängig. Bei Fragen kontaktieren Sie bitte uns oder Ihren 
    Provider.

- manuelle Ausführung

  Alle Aufgaben können auch manuell für jede Bestellung ausgeführt werden. Ob dies für die Aufgabe sinnvoll erscheint, 
  können Sie mit dem Haken [ manuelle Ausführung an Bestellung möglich ] festlegen. Haben Sie den Haken gesetzt, wird 
  diese Aufgabe an den Bestellungen (im Admin unter [ Bestellungen verwalten ] -> [ Bestellungen ] -> 
  [ D3 Auftragsmanager ]) angezeigt. (siehe auch [Aufgaben manuell ausführen](../../alternative_ausfuehrungswege/aufgaben_fuer_alle_relevanten_bestellungen_manuell_ausfuehren.md)).
  
  Mit "Aufgabe wird nur bei Bestellungen angeboten, bei denen die eingestellten Bedingungen erfüllt sind" können Sie 
  entscheiden, ob die Aufgabe an jeder Bestellung angezeigt werden soll oder nur an Bestellungen, die die eingestellten 
  Bedingungen erfüllen.

- nach dem Abschluss der Bestellung durch den Kunden

  Die Aufgabe wird dann ausgeführt, wenn der Kunde seine Bestellung im Bestellschritt 4 abgesendet hat und diese vom 
  Shop angelegt wurde. Die Aufgabe führt dann nur diese eine Bestellung aus, wenn diese die eingestellten Bedingungen 
  erfüllt.
  
!!! note
    Technisch gesehen erfolgt die Bearbeitung der Bestellung nach Ausführung von 
    \OxidEsales\Eshop\Application\Model\Order::finalizeOrder()
  
- nach jedem Speichern der Bestellung

  Die Ausführung der Aufgabe erfolgt immer dann, wenn eine Bestellung gespeichert wird. Je nachdem, ob die bearbeitete 
  Bestellung als "erledigt" markiert wird, erfolgt (k)eine erneute Bearbeitung beim nächsten Speichern.
  
  Dieser Auslöser und der Auslöser "nach dem Abschluss der Bestellung durch den Kunden" überschneiden sich thematisch, 
  da beim Abschluss der Bestellung diese ebenfalls gespeichert wird. Eine gleichzeitige Aktivierung dieser beiden 
  Auslöser ergibt i.d.R. keinen Sinn.
  
!!! note
    Technisch gesehen erfolgt die Bearbeitung der Bestellung nach Ausführung von 
    \OxidEsales\Eshop\Application\Model\Order::save()

- programmierbare Auslöser
  
  Die Ausführung der Ausgabe erfolgt dann, wenn im Shop der Auslösercode gestartet wird. Dies kann an jeder beliebigen 
  Stelle im Code passieren. Weitere Informationen zur Integration des Auslösers finden Sie im Kapitel 
  [Aufgaben mit programmierbarem Auslöser starten](../../alternative_ausfuehrungswege/aufgaben_mit_programmierbarem_ausloeser_starten.md).

  Dieser Auslöser steht in der [Premium-Edition](../../../editionen.md) zur Verfügung.

Aktive Auslöser werden für die schnelle Übersicht mit einem grünen Häkchen markiert.

An jedem Auslöser können Sie die Ausführung eines Vorab-Skripts und / oder eines Danach-Skripts einstellen, das 
vorbereitende oder nachbereitende Arbeiten ausführt. Diese Funktion steht in der [Premium-Edition](../../../editionen.md) 
zur Verfügung.

Speichern Sie gesetzte Einstellungen ab.
