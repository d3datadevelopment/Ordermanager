# Cronjobs für unterschiedlich zu steuernde Aufgaben

Mit der **Cronjob-ID** legen Sie fest, **welche Aufgaben zusammen** durch einen Cronjob gestartet werden.

Kurz gesagt:

- **Cronjob-ID = Gruppierung von Aufgaben**
- **ein Cronjob-Aufruf je ID**
- **pro ID eigenes Intervall** (z. B. täglich, wöchentlich, monatlich)

## Standardverhalten

Neue oder nicht zugeordnete Aufgaben haben automatisch die Cronjob-ID **0**.
Diese Aufgaben werden über den Standard-Cronjob des Moduls ausgeführt.

## Beispiel aus der Praxis

- Aufgabe **Bewertungsaufforderung**: soll **täglich** laufen
- Aufgabe **Buchhaltungsexport**: soll **wöchentlich** laufen

Lösung:

- Bewertungsaufforderung erhält z. B. Cronjob-ID **1**
- Buchhaltungsexport erhält z. B. Cronjob-ID **2**
- Für ID 1 richten Sie einen täglichen Cronjob ein
- Für ID 2 richten Sie einen wöchentlichen Cronjob ein

So lassen sich unterschiedliche Intervalle sauber trennen.

## Einrichtung in 3 Schritten

1. Tragen Sie an der Aufgabe eine passende Cronjob-ID ein (1 bis 99).
2. Speichern Sie die Aufgabe.
3. Verwenden Sie den in den Modul-Grundeinstellungen angezeigten Aufruf für diese ID und richten Sie dafür einen eigenen Server-Cronjob mit passendem Intervall ein.

Wenn mehrere Aufgaben denselben Zeitplan haben, vergeben Sie einfach dieselbe Cronjob-ID. Dann reicht ein gemeinsamer Cronjob.

## Hinweis zur Abwärtskompatibilität

Wird ein Cronjob-Aufruf ohne explizite ID gestartet, verwendet das Modul automatisch Cronjob-ID **0**. Bestehende Setups funktionieren daher weiterhin ohne Anpassung.

Sofern Ihr Provider dies erfordert, legen Sie für jeden Cronjob eine separate `.sh`-Datei an (siehe [Cronjob-Einrichtung](aufgaben_automatisch_ausfuehren.md)).
