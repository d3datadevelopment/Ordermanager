# Deinstallation

1. [Schritt 1: Modulerweiterungen deaktivieren und entfernen](#schritt-1-modulerweiterungen-deaktivieren-und-entfernen)
2. [Schritt 2: Modul deaktivieren](#schritt-2-modul-deaktivieren)
3. [Schritt 3: Modul aus der Installation entfernen](#schritt-3-modul-aus-der-installation-entfernen)
4. [Schritt 4: Datenbank bereinigen](#schritt-4-datenbank-bereinigen)
5. [Schritt 5: TMP-Ordner leeren](#schritt-5-tmp-ordner-leeren)


## Schritt 1: Modulerweiterungen deaktivieren und entfernen

Deaktivieren Sie alle vorhandenen Erweiterungen, die auf dem Modul **{{ modulename }}** aufbauen. Entfernen Sie ebenfalls alle individuellen Templateanpassungen für dieses Modul.

## Schritt 2: Modul deaktivieren

=== ":material-monitor: Adminbereich"

    Deaktivieren Sie das Modul unter [ Erweiterungen ] -> [ Module ]. Klicken Sie nach Auswahl von [ {{ menutitle }} ] auf den Button [ Deaktivieren ].

=== ":material-console: Kommandozeile"

    Alternativ können Sie die Moduldeaktivierung auch über die Kommandozeile (CLI) im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) durchführen.

    ```bash
    ./vendor/bin/oe-console oe:module:deactivate {{ metadataident }}
    ```

    !!! note "Enterprise Edition"
        Achten Sie darauf, dass das Modul in allen weiteren Shops (Mall) ebenfalls deaktiviert werden muss.

        Zur Deaktivierung in einem bestimmten Shopmandanten verwenden Sie das `--shop-id`-Argument (`...oe-console --shop-id 1 oe:module...`)

## Schritt 3: Modul aus der Installation entfernen

=== ":material-console: Kommandozeile"

    Starten Sie die Konsole Ihres Webservers und wechseln in das Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses). Führen Sie Sie dort diesen Befehl aus:

    ```Bash
    php composer remove {{ composerident }} --no-update
    ``` 

    !!! note
        Benötigt Ihre Installation einen anderen Aufruf von Composer, ändern Sie den Befehl bitte entsprechend ab. Für weitere Optionen dieses Befehls lesen Sie bitte die [Dokumentation von Composer](https://getcomposer.org/doc/03-cli.md#remove).

## Schritt 4: Datenbank bereinigen

Das Modul legt Informationen in der Datenbank ab. Sofern diese Daten nicht mehr benötigt werden, können diese gelöscht werden. 

!!! note
    Legen Sie sich vorab bitte unbedingt eine Sicherung an, um die Daten im Zweifelsfall wiederherstellen zu können.
    
Für das Modul **{{ modulename }}** sind dies die folgende Tabellen und Felder:

* die komplette Tabelle `d3order2ordermanager`
    
und diese Felder in bestehenden Tabellen:

* in Tabelle `d3modprofile`:  
  * das Feld `D3_OM_EXECMANUALLY`
  * das Feld `D3_OM_MARKORDER`
  * das Feld `D3_OM_ORDERSAVETRIGGERED`
  * das Feld `D3_OM_ORDERFINISHTRIGGERED`
  
sowie diese Einträge in bestehenden Tabellen:

* in Tabelle `d3_cfg_mod`:  
  * den Eintrag `oxmodid = "{{ modcfgident }}"` 1)

1) Diesen Eintrag gibt es ggf. für jeden Subshop. Entfernen Sie diesen nur für die Mandanten, in denen das Modul **nicht** mehr installiert ist. 

## Schritt 5: TMP-Ordner leeren

=== ":material-monitor: Adminbereich"

    Leeren Sie das Verzeichnis `tmp` über [ Admin ] -> [ (D3) Module ] -> [ Modul-Connector ] -> [ TMP leeren ]. Markieren Sie [ komplett leeren ] und klicken auf [ TMP leeren ]. 

    Sofern die Views nicht automatisch aktualisiert werden, führen Sie dies noch durch.

=== ":material-console: Kommandozeile"

    Alle TMP-leeren-Aktionen stehen Ihnen ebenfalls auf der Kommandozeile (CLI) zur Verfügung. Führen Sie diesen Befehl im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) aus:

    ```bash
    ./vendor/bin/d3cleartmp
    ```

    !!! note
        Erfordert Ihre Installation eine andere Vorgehensweise zum Leeren des Caches oder zum Aktualisieren der Datenbank-Viewtabellen, führen Sie diese bitte aus.

        Beim Kommandozeilenaufruf werden Ihnen weitere Optionen gezeigt, mit denen Sie die Aktion gezielt steuern können.