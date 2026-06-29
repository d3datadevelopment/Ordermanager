# Update

1. [Schritt 1: Modul deaktivieren](#schritt-1-modul-deaktivieren)
2. [Schritt 2: Dateien erneuern](#schritt-2-dateien-erneuern)
3. [Schritt 3: Modulinformationen aktualisieren](#schritt-3-modulinformationen-aktualisieren)
4. [Schritt 4: Shopanpassungen installieren](#schritt-4-shopanpassungen-installieren)
5. [Schritt 5: TMP-Ordner leeren](#schritt-5-tmp-ordner-leeren)
6. [Schritt 6: Lizenzschlüssel aktualisieren](#schritt-6-lizenzschlussel-aktualisieren)
7. [Schritt 7: Erweiterungen anpassen](#schritt-7-erweiterungen-anpassen)


## Voraussetzung

Die Updateanweisungen können verwendet werden, wenn dieses Modul schon früher mit Hilfe von Composer installiert wurde.

Wurde die Installation bisher noch nicht durchgeführt oder die Installation wurde **nicht** über Composer 
durchgeführt (weil das Modul dies z.B. früher nicht unterstützte), verwenden Sie bitte die Beschreibung unter [Neuinstallation](start.md).

## Schritt 1: Modul deaktivieren

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

## Schritt 2: Dateien erneuern

=== ":material-console: Kommandozeile"

    Starten Sie die Konsole Ihres Webservers und wechseln in das Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses). Führen Sie dort diesen Befehl aus:

    ```bash
    php composer require {{ composerident }}:^{{ moduleversion }} --update-no-dev
    ```

    Im weiteren Ablauf werden Sie gefragt, ob die Moduldateien überschrieben werden sollen. Bestätigen Sie dies für den Eintrag `{{ composerident }}`.

    !!! note
        Achten Sie darauf, dass Composer für die Installation dieselbe PHP-Version verwendet, in der auch Ihr Shop ausgeführt wird. Sie erhalten sonst möglicherweise unpassende Modulpakete.

        Benötigt Ihre Installation einen anderen Aufruf von Composer, ändern Sie den Befehl bitte entsprechend ab. Für weitere Optionen dieses Befehls lesen Sie bitte die [Dokumentation von Composer](https://getcomposer.org/doc/03-cli.md#require).

## Optional: Providerspezifische Installation

Manche Provider erfordern besondere Einstellungen für installierte Module. Treffen Sie bei der Installation auf spezielle Anforderungen, zu denen Sie Unterstützung benötigen, kontaktieren Sie uns bitte für weiteren Support.

## Schritt 3: Modulinformationen aktualisieren

=== ":material-monitor: Adminbereich"

    Wechseln Sie im Adminbereich zu [ Erweiterungen ] -> [ Module ]. Klicken Sie nach Auswahl von [ {{ menutitle }} ] auf den Button [ Aktivieren ].

=== ":material-console: Kommandozeile"

    Alternativ können Sie die Modulaktivierung auch über die Kommandozeile (CLI) im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) durchführen. 

    ```bash
    ./vendor/bin/oe-console oe:module:activate {{ metadataident }}
    ```

    !!! note "Enterprise Edition"
        Achten Sie darauf, dass das Modul in weiteren Shops (Mall) ebenfalls aktiviert werden muss, um dessen Funktion dort auch zu nutzen.

        Zur Aktivierung in einem bestimmten Shopmandanten verwenden Sie das `--shop-id`-Argument (`...oe-console --shop-id 1 oe:module...`)

## Schritt 4: Shopanpassungen installieren

=== ":material-monitor: Adminbereich"

    Ob Shopanpassungen notwendig sind, ist von der Versionsänderung des Moduls abhängig.

    Möglicherweise sehen Sie nach dem Neuaktivieren des Moduls den Installationsassistent, der Sie durch die Änderungen führt. Folgen Sie dann den einzelnen Schritten. Möchten Sie die Änderungen manuell installieren, können Sie sich über diesen Assistenten ebenfalls eine Checkliste erstellen.

    Wird der Assistent nicht gezeigt (Sie sehen wieder die Modulübersicht), waren keine Anpassungen am Shop notwendig.

    Ob erforderliche Updates ausgeführt werden sollen, können Sie jederzeit im Adminbereich unter [ (D3) Module ] -> [ Modul-Connector ] -> [ Modulverwaltung ] -> [ Modulinstallation ] prüfen.

=== ":material-console: Kommandozeile"

    Der Installationsassistent steht Ihnen ebenfalls auf der Kommandozeile (CLI) zur Verfügung. Führen Sie diesen Befehl im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) aus:

    ```bash
    ./vendor/bin/d3modules_install
    ```

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

## Schritt 6: Lizenzschlüssel aktualisieren

=== ":material-monitor: Adminbereich"

    Wird für die neue Modulversion ein aktualisierter Lizenzschlüssel benötigt, tragen Sie diesen im Adminbereich unter [ (D3) Module ] -> [ Modul-Connector ] -> [ Modulverwaltung ] ein. Klappen Sie dazu den Eintrag des jeweiligen Moduls aus und starten den Lizenzassistent.

=== ":material-console: Kommandozeile"

    ```bash
    ./vendor/bin/oe-console d3:modcfg:license:set <shop id> <module id> <license key>
    ```

## Schritt 7: Erweiterungen anpassen

Haben Sie für dieses Modul eigene Erweiterung entwickelt, gleichen Sie dies bitte mit der neuen Fassung des Moduls ab.
