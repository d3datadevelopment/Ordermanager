# Aufrufdaten je Cronjob-ID

!!! info "Pfad im Adminbereich"
    [ (D3) Module ] -> [ Auftragsmanager ] -> [ Einstellungen ] -> [ Grundeinstellungen ] -> [ Aufrufdaten für Cronjob-ID ]

Hier sehen Sie die Aufrufdaten für eine konkrete **Cronjob-ID**.

Die Cronjob-ID bestimmt, welche Aufgaben zusammen ausgeführt werden. Dadurch können Sie unterschiedliche Intervalle abbilden (z. B. täglich oder wöchentlich). Grundlagen dazu finden Sie unter [Cronjobs für unterschiedlich zu steuernde Aufgaben](../../ausfuehrung_mit_cronjob/cronjobs_fuer_unterschiedlich_zu_steuernde_aufgaben.md).

## Was Sie in diesem Bereich sehen

- **Interner Cronaufruf**: Diesen Aufruf verwenden Sie für den echten Server-Cronjob.
- **Skript-Erzeugung**: Optional können Sie passende Shell-Skripte für den Aufruf erzeugen.
- **Externer Link**: Nur für manuellen Test im Browser, nicht für produktive Cronjob-Aufrufe.
- **Letzte Ausführung**: Zeigt, wann der Cronjob mit dieser ID zuletzt erfolgreich gestartet wurde.

## Vorgehen

1. Weisen Sie Ihren Aufgaben die gewünschte Cronjob-ID zu.
2. Übernehmen Sie den internen Aufruf dieser ID.
3. Richten Sie beim Provider dafür einen Cronjob mit passendem Intervall ein.

Speichern Sie Ihre Einstellungen anschließend.

!!! note "Enterprise Edition mit mehr als einem Shopmandanten"
    Für jeden Shopmandanten existiert ein eigener Aufruf. Richten Sie je Mandant einen separaten Cronjob ein, idealerweise zeitversetzt.
