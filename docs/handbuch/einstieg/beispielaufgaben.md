# Beispielaufgaben

Der Auftragsmanager deckt viele unterschiedliche Anwendungsfälle ab. Die folgenden Beispielaufgaben sollen Ihnen einen 
schnellen gedanklichen Einstieg geben und typische Einsatzmöglichkeiten zeigen.

Einige dieser Beispiele werden in einer Standardinstallation bereits mitgeliefert, andere dienen als zusätzliche 
Anregung. Unabhängig davon können Sie alle hier gezeigten Aufgaben als Vorlage für Ihre eigenen Prozesse verwenden und 
an Ihre Anforderungen anpassen.

## personalisierte Neukundenbegrüßung

Sendet Neukunden zeitnah nach Bestelleingang eine Infoemail, die eine herzliche Begrüßung enthält und in der die Vorzüge und Abläufe des Shops dargestellt werden.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich oder nach dem Abschluss der Bestellung durch den Kunden (Premium-Edition)
    - **Bedingungen:**
        - Kundengruppe: "noch nicht bestellt"
    - **Aktionen:**
        - E-Mail an Kunde

## Zahlungserinnerung

Sendet Kunden 3 Tage nach Bestelleingang automatisch eine freundliche Zahlungserinnerung, wenn noch kein Zahlungseingang verbucht ist. Das reduziert offene Bestellungen und verbessert den Cashflow.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - nicht bezahlt
        - Zeitraum: 3 Tage nach Bestelleingang
    - **Aktionen:**
        - E-Mail an Kunde

## Danke-Mail nach Versand

Versendet 2 Tage nach Versand automatisch eine Dankesmail mit Bitte um Feedback oder Bewertung. Das stärkt die Kundenbindung und erhöht die Chance auf positive Rückmeldungen.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - Versanddatum gesetzt
        - Zeitraum: 2 Tage nach Versand
    - **Aktionen:**
        - E-Mail an Kunde

## VIP-Kunde automatisch zuweisen

Ordnet Kunden bei Bestellungen über einem definierten Betrag automatisch einer VIP-Kundengruppe zu. So lassen sich Kunden gezielt ansprechen und besondere Konditionen hinterlegen.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - Bestellsumme größer als 500 EUR
    - **Aktionen:**
        - Kundengruppe zuordnen

## Rechnungs-Export für Buchhaltung

Exportiert regelmäßig Bestellungen mit Rechnungsnummer als CSV- oder XML-Datei und verschiebt sie anschließend in einen Export-Ordner. Das vereinfacht die Übergabe an Buchhaltung oder Steuerberater.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - hat Rechnungsnummer
        - nicht in Ordner "Exportiert"
    - **Aktionen:**
        - Export in Liste
        - in Ordner verschieben

## Versand vergessen - Alarm

Informiert den Shopbetreiber automatisch, wenn bezahlte Bestellungen nach 2 Tagen noch nicht versendet wurden. Das hilft, Verzögerungen zu vermeiden und die Kundenzufriedenheit zu sichern.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - bezahlt
        - Versanddatum nicht gesetzt
        - Zeitraum: 2 Tage nach Zahlungseingang
    - **Aktionen:**
        - E-Mail an Shopbetreiber

## Express-Bestellungen priorisieren

Verschiebt Bestellungen mit Expressversand automatisch in einen Prioritätsordner. Das sorgt für schnelle Bearbeitung und bessere Übersicht im Tagesgeschäft.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - Versandart = Express
    - **Aktionen:**
        - in Ordner verschieben

## Problemfälle markieren

Markiert Bestellungen mit bestimmten Artikeln und höherem Warenwert zur manuellen Prüfung. Das unterstützt die Qualitätssicherung und reduziert Fehlversendungen.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - enthält selektierte Artikel
        - Bestellsumme größer als 200 EUR
    - **Aktionen:**
        - in Ordner verschieben

## Automatisches Storno bei Zahlungsfehler

Storniert Bestellungen automatisch, wenn ein Zahlungsversuch fehlgeschlagen ist und keine Korrektur erfolgt. Das verhindert unnötige Nacharbeit und hält den Shop sauber.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - Transaktionsstatus = NOK
        - Zeitraum: 1 Tag nach Bestelleingang
    - **Aktionen:**
        - Bestellung stornieren
        - optional: Bestellung löschen

## Fehlender Trackingcode

Meldet Bestellungen, die als versendet markiert sind, aber keinen Trackingcode enthalten. Das unterstützt saubere Versandprozesse und reduziert Rückfragen von Kunden.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - Versanddatum gesetzt
        - kein Trackingcode
        - Zeitraum: 1 Tag nach Versand
    - **Aktionen:**
        - E-Mail an Shopbetreiber

## Hochpreisige Bestellungen markieren

Kennzeichnet Bestellungen über einem definierten Betrag zur besonderen Prüfung oder Absicherung. Das reduziert Risiken bei hochpreisigen Sendungen.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - Bestellsumme größer als 1000 EUR
    - **Aktionen:**
        - in Ordner verschieben

## Cross-Selling Follow-Up

Sendet Kunden einige Tage nach Versand passende Produktempfehlungen basierend auf der Bestellung. Das unterstützt Zusatzverkäufe und steigert den Kundenwert.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - enthält selektierte Artikel
        - Zeitraum: 7 Tage nach Versand
    - **Aktionen:**
        - E-Mail an Kunde

## Anti-Fraud Basisprüfung

Markiert Bestellungen mit auffälligen Kombinationen wie hohem Warenwert und abweichenden Adressdaten. Das unterstützt die Erkennung potenzieller Betrugsfälle.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - Bestellsumme größer als 300 EUR
        - Lieferadresse ungleich Rechnungsadresse
    - **Aktionen:**
        - in Ordner verschieben

## E-Mail-Muster prüfen

Erkennt auffällige E-Mail-Adressen anhand definierter Muster und markiert diese Bestellungen. Das kann Hinweise auf Missbrauch oder Testkäufe liefern.

??? note "Konfiguration"
    - **Verfügbar ab:** Standard-Edition
    - **Auslöser:** beim Speichern der Bestellung
    - **Bedingungen:**
        - Suchmuster in Mailadresse
    - **Aktionen:**
        - in Ordner verschieben

## ERP / CRM Integration

Sendet Bestelldaten automatisch an externe Systeme per Push-Notification. Das ermöglicht die Integration in ERP-, CRM- oder Fulfillment-Prozesse.

??? note "Konfiguration"
    - **Verfügbar ab:** Premium-Edition
    - **Auslöser:** nach dem Abschluss der Bestellung durch den Kunden
    - **Bedingungen:**
        - optional
    - **Aktionen:**
        - Push-Notification senden

## Vergessene Bestellungen bereinigen

Identifiziert alte, unbezahlte und unbearbeitete Bestellungen und informiert den Shopbetreiber oder storniert diese optional. Das hält den Datenbestand übersichtlich.

??? note "Konfiguration"
    - **Verfügbar ab:** Free-Edition, mit optionalem Storno ab Standard-Edition
    - **Auslöser:** Cronjob, täglich
    - **Bedingungen:**
        - nicht bezahlt
        - Versanddatum nicht gesetzt
        - Zeitraum: 30 Tage nach Bestelleingang
    - **Aktionen:**
        - E-Mail an Shopbetreiber
        - optional: Bestellung stornieren
