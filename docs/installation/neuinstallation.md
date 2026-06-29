# Neuinstallation

1. [Schritt 1: Modul zur Installation hinzufügen](#schritt-1-modul-zur-installation-hinzufugen)
2. [Schritt 2: Modul im Shop aktivieren](#schritt-2-modul-im-shop-aktivieren)
3. [Schritt 3: Shopanpassungen installieren](#schritt-3-shopanpassungen-installieren)
4. [Schritt 4: TMP-Ordner leeren](#schritt-4-tmp-ordner-leeren)
5. [Schritt 5: Lizenzschlüssel eintragen](#schritt-5-lizenzschlussel-eintragen)
6. [Schritt 6: Cronjob einrichten](#schritt-6-cronjob-einrichten)
7. [Schritt 7: Nachträgliche Anpassung der Installationsumgebung](#schritt-7-nachtragliche-anpassung-der-installationsumgebung)
8. [Schritt 8: Schnellstart](#schritt-8-schnellstart)


## Schritt 1: Modul zur Installation hinzufügen

=== ":material-console: Kommandozeile"

    Führen Sie in der Konsole im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) diesen Befehl aus, um das Modul **{{ modulename }}** zur Installation hinzuzufügen:

    ```bash
    php composer require {{ composerident }}:^{{ moduleversion }} --update-no-dev
    ``` 

    !!! note
        Achten Sie darauf, dass Composer für die Installation dieselbe PHP-Version verwendet, in der auch Ihr Shop ausgeführt wird. Sie erhalten sonst möglicherweise unpassende Modulpakete.

        Benötigt Ihre Installation einen anderen Aufruf von Composer, ändern Sie den Befehl bitte entsprechend ab. Für weitere Optionen dieses Befehls lesen Sie bitte die [Dokumentation von Composer](https://getcomposer.org/doc/03-cli.md#require).

## Optional: Providerspezifische Installation

Manche Provider erfordern besondere Einstellungen für installierte Module. Treffen Sie bei der Installation auf spezielle Anforderungen, zu denen Sie Unterstützung benötigen, kontaktieren Sie uns bitte für weiteren Support.

## Schritt 2: Modul im Shop aktivieren

=== ":material-monitor: Adminbereich"

    Aktivieren Sie das Modul über den Shopadmin unter [ Erweiterungen ] -> [ Module ]. Klicken Sie nach Auswahl von [ {{ menutitle }} ] auf den Button [ Aktivieren ].

=== ":material-console: Kommandozeile"

    Alternativ können Sie die Modulaktivierung auch auf der Kommandozeile (CLI) im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) durchführen. 

    ```bash
    ./vendor/bin/oe-console oe:module:activate {{ metadataident }}
    ```

    !!! note "Enterprise Edition"
        Achten Sie darauf, dass das Modul in weiteren Shops (Mall) ebenfalls aktiviert werden muss, um dessen Funktion dort auch zu nutzen.

        Zur Aktivierung in einem bestimmten Shopmandanten verwenden Sie das `--shop-id`-Argument (`...oe-console --shop-id 1 oe:module...`)

## Schritt 3: Shopanpassungen installieren

=== ":material-monitor: Adminbereich"

    Direkt nach der Modulaktivierung startet der Assistent, der Sie durch die Shopanpassung führt. Darin können Sie verschiedene Optionen der Installation wählen.

    Den Installationsassistenten finden Sie auch unter den Menüpunkten [ Admin ] -> [ (D3) Module ] -> [ Modul-Connector ] -> [ Modulverwaltung ] -> [ Modulinstallation ].

    Bei tiefgreifenden Änderungen an Ihrem Shop (z.B. Hinzufügen weiterer Sprachen oder Mandanten) rufen Sie den Installationsassistenten bitte erneut auf, um dann eventuell notwendige Nacharbeiten für das Modul ausführen zu lassen.

    Möchten Sie die Änderungen manuell installieren, können Sie sich über diesen Assistenten ebenfalls eine Checkliste erstellen.

=== ":material-console: Kommandozeile"

    Der Installationsassistent steht Ihnen ebenfalls auf der Kommandozeile (CLI) zur Verfügung. Führen Sie diesen Befehl im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) aus:

    ```bash
    ./vendor/bin/d3modules_install
    ```

## Schritt 4: TMP-Ordner leeren

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

## Schritt 5: Lizenzschlüssel eintragen

=== ":material-monitor: Adminbereich"

    Das Modul verwendet Lizenzschlüssel, um die Lizenzverwaltung für Sie und auch für uns einfacher zu gestalten. Hierbei haben Sie je nach Modul die Wahl zwischen einer kostenfreien Testlizenz und einer Lizenz für den Einsatz im Livebetrieb.

    Speziell der **{{ modulename }}** wird in unterschiedlichen (teilweise kostenfreien) Editionen für den Livebetrieb angeboten. Besuchen Sie unseren [Moduleshop](https://www.oxidmodule.com/), um mehr darüber zu erfahren.

    Rufen Sie zum Anfordern des Lizenzschlüssels die Modulverwaltung im Adminbereich unter [ (D3) Module ] -> [ Modul-Connector ] -> [ Modulverwaltung ] auf. Klappen Sie den Eintrag des jeweiligen Moduls aus. Sofern erforderlich, können Sie hier den Lizenzassistenten starten, der schnell und einfach ihr Modul aktiviert.

=== ":material-console: Kommandozeile"

    ```bash
    ./vendor/bin/oe-console d3:modcfg:license:set <shop id> <module id> <license key>
    ```

## Schritt 6: Cronjob einrichten

Legen Sie den Cronjob für die automatische Bearbeitung der eingerichteten Aufträge an. Die für die Anlage benötigten Daten finden Sie im Adminbereich des Moduls unter [ (D3) Module ] -> [ {{ menutitle }} ] -> [ Einstellungen ] -> [ Grundeinstellungen ]. Weitere Informationen zum Anlegen von Cronjobs finden Sie in unserer [FAQ](https://faq.d3data.de/technik/wie-werden-cronjobs-angelegt/).

!!! warning
    Sie sollten unbedingt den Aufruf von `.sh`-Dateien via Browser verhindern, so dass kein Unbefugter die Datei von außen aufrufen kann. Dazu können Sie z.B. die `.htaccess`-Datei des Shops um folgende Zeilen erweitern:

```htaccess
    <Files *.sh>
      Require all denied
    </Files>
```

## Updatefähigkeit

Bei individuellen Änderungen von Moduldateien empfehlen wir, jeweils die Überladungsmöglichkeiten des Shops dafür zu verwenden. So brauchen Sie die originalen Moduldateien nicht verändern und erhalten sich so die Updatefähigkeit des Shops und des Moduls. Beachten Sie, dass Moduldateien bei Updateinstallationen überschrieben werden.

Weitere Informationen zu den Überladungsmöglichkeiten verschiedener Dateien finden Sie in unserer [FAQ](https://faq.d3data.de/category/oxid-eshop/module-oxid-eshop/anpassungen/).

## Schritt 7: Nachträgliche Anpassung der Installationsumgebung

Die Installation prüft die Anforderungen des Moduls zum jeweiligen Zeitpunkt. Sollen später Einstellungen der Umgebung geändert werden (z.B. neue PHP-Version), sollte vorab über Composer geprüft werden, ob die bisherige Paketzusammenstellung weiterhin gültig ist und auch die neuen Anforderungen erfüllt werden. Unter Umständen ist eine Aktualisierung der Paketzusammenstellung nötig.

## Schritt 8: Schnellstart

Das Modul **{{ modulename }}** bringt einen umfangreichen Adminbereich mit, in dem Sie die Konfigurationseinstellungen des Moduls setzen können. Über das Menü [ (D3) Module ] -> [{{ menutitle }}] -> [Einstellungen] erreichen Sie die Einstellseiten. Arbeiten Sie idealerweise die Optionen einmal durch. Hinweise zu den einzelnen Einstellungen finden Sie in dem dahinter stehenden Fragezeichenfeld. Durch einen Klick darauf öffnet sich der Hinweistext.

Richten Sie nun die Aufgaben ein, die der "Auftragsmanager" für Sie durchführen soll. In der Standardinstallation finden Sie einige Aufgaben als Beispiel vorbereitet. Darin können Sie sich die möglichen Konfigurationen ansehen, diese auf Ihre Bedürfnisse anpassen und auch neue Aufgaben anlegen.

Testen Sie die Aufgaben mit dem modulweiten Debug-Schalter ([ (D3) Module ] -> [ Auftragsmanager ] -> [ Einstellungen ]) und / oder der Mailsende-Option an jeder Aufgabe ([ (D3) Module ] -> [ Auftragsmanager ] -> [ Aufgaben ] -> [ Stamm ]). Diese Optionen sind genauer im jeweils dahinter stehenden Fragezeichenfeld erklärt. Aktivieren Sie die Ausführung der Aufgaben bitte erst, wenn Sie sicher sind, dass alle Optionen richtig sind. Wir übernehmen keine Gewährleistung für evtl. falsche oder verlorene Daten bei fehlerhaft eingestellten Aufgaben.

Weitere Details zur Einrichtung des "Auftragsmanagers" entnehmen Sie bitte dessen [Handbuch zum Modul](../handbuch/einstieg/inhalte.md).
