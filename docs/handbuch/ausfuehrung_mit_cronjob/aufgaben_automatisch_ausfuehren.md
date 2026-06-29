# Cronjob-Einrichtung

Damit Aufgaben automatisch laufen, richten Sie auf dem Server einen oder mehrere Cronjobs ein.
Als Aufruf verwenden Sie den in den Modul-Einstellungen angezeigten Link.

Wie oft der Cronjob laufen soll, hängt von Ihren Aufgaben ab (z. B. stündlich, täglich, wöchentlich).

## Vorgehen

1. Öffnen Sie im Shop die Modul-Einstellungen des Auftragsmanagers.
2. Kopieren Sie den dort angezeigten Cronjob-Aufruf.
3. Legen Sie beim Provider einen Cronjob mit diesem Aufruf und passendem Intervall an.

## Mehrere Cronjobs

Wenn Sie Aufgaben mit unterschiedlichen Intervallen trennen möchten, verwenden Sie zusätzliche Cronjob-IDs und richten je ID einen eigenen Cronjob ein (siehe [Cronjobs für unterschiedlich zu steuernde Aufgaben](cronjobs_fuer_unterschiedlich_zu_steuernde_aufgaben.md)).

## Hinweis zu `.sh`-Skripten

Sofern Ihr Provider es verlangt, verwenden Sie statt des direkten PHP-Aufrufs eine passende `.sh`-Datei.
Passen Sie die Datei an Ihre Serverumgebung an.

## Sicherheits-Hinweis

Der Aufruf von `.sh`-Dateien sollte nicht öffentlich über den Browser möglich sein.
Ergänzen Sie z. B. in der `.htaccess` folgende Regel:

```sh
<Files *.sh>
  order allow,deny
  deny from all
</Files>
```
