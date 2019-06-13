---
title: Wartungstool
---

Die generierten Bilder müssen nach dem Setzen der Wasserzeicheneinstellungen neu aufbereitet werden. Ebenso ist die Aufbereitung nötig, wenn neue Artikel in den Shop eingepflegt wurden. Bestehen schon frühere Artikelbilder, müssen diese vorab gelöscht werden.

Das Löschen der Bilder kann direkt auf dem Server, im Adminbereich des Shops oder über das hier angesprochene Wartungstool erledigt werden.

Die Neugenerierung passiert regulär dann, wen das jeweilige Bild zum ersten Mal angefordert wird. Dies passiert im Normalfall durch die Shopbesucher. Somit ist eigentlich keine separate Vorarbeit nötig.

Da jedoch die Einarbeitung des Wasserzeichens etwas Leistung (und damit auch Zeit) benötigt, sollten die Bilder vorgeneriert werden, um die erstmalige Ladezeit des Shops nicht unnötig zu verlängern. Daher kann die Vorabgenerierung ebenfalls über das folgende Wartungstool ausgeführt wird.

Das moduleigene Wartungstool rufen Sie bitte über die Konsole Ihres Servers auf.
Führen Sie in der Konsole im Hauptverzeichnis Ihres Shops (oberhalb des `source`- und `vendor`-Verzeichnisses) diesen Befehl aus, um das Wartungstool zu starten:

```bash
./vendor/bin/d3watermark
``` 

Damit sehen Sie eine Übersicht über die verfügbaren Befehlsoptionen.

Folgende Aktionen stehen Ihnen zur Verfügung:

- delete: Löschen der generierten Bilder
- generate: Neugenerieren der Bilder
- renew: Löschen **und** Neugenerieren der Bilder

Diesen Aktionen ist noch die Angabe hinzuzufügen, welche Bilder damit bearbeitet werden sollen. Mögliche Optionen sind:

- product: alle Artikelbilder
- category: alle Kategoriebilder
- manufacturer: alle Markenbilder
- vendor: alle Lieferantenbilder
- wrapping: alle Verpackungsbilder
- all: alle Bilder der vorher genannten Objekte

Zum Neugenerieren aller Bilder sieht der Aufruf dann beispielsweise so aus:

```bash
./vendor/bin/d3watermark renew all
``` 

> [i] Beachten Sie, dass der Scriptaufruf mit dem Systembenutzer erfolgt, der die generierten Dateien auch löschen darf. Ändern Sie den Befehl bitte ansonsten entsprechend systemabhängig ab (`sudo -u www-data ./vendor/bin/d3watermark ...`). Beim Neugenerieren ist der verwendete Benutzer unrelevant.

> [i] Sollen diese Wartungsaufgaben automatisert (z.B. per Cronjob) ausgeführt werden, stehen Ihnen die Optionen `--no-color` und `--loglevel error` zur Verfügung, um unnötige Ausgaben zu vermeiden.