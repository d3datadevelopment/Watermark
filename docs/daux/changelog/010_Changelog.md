---
title: Changelog
---

## 3.0.0.0 - (2019-05-08)

**Minor version upgrade notice: there are some backward-incompatible changes to this release.**

#### Added
- Angepasst für Shopversion 6.x, Installation via Composer 

#### Changed
- JPEG als mögliche Dateiendung hinzugefügt
- verwendet intervention Bildbibliothek zur grafischen Verarbeitung 
- Kategoriethumbnails hinzugefügt
- Logik des Löschens generierter Bilder basiert auf der Connector-Umsetzung
- teilweises Löschen der generierten Bilder hinzugefügt
- HTML-Dokumentation eingefügt

---

## 2.1.0.0
- Sprachabhängige Modul-Einstellungen deaktivert
- generelle Überabreitungen im Admin
- integration eines Popup um generierte Bilder zu entfernen, nach Änderung von Wasserzeichen oder Einstellungsdaten
- EE Handling überarbeitet:
  - unterschiedliche Wasserzeichenbilder je Mandant
  - Bildegererierung in Mandanten mit inaktivem Modul

---

## 2.0.2.1
- ionCube Unterstützung implementiert
- Anpassung der htaccess-Files für Apache 2.4 (ohne Kompatibilitätsmodus)

---

## 2.0.2.0
- Transparenz vom Produktbild wird entfernt (mit Wasserzeichen)
- Freigabe für PHP 5.5 und 5.6

---

## 2.0.1.0
- Aktualisierung der Installation und Vorabprüfung (precheck)
- Transparenz vom Produktbildern beibehalten (Verschmelzung von PNG + PNG)
- Modulfreigabe bis PHP 5.5 und 5.6

---

## 2.0.1.0
- syntaktische Korrektur in CSS und HTML
- vervollständigung der automatischen Installation
- Übernahme des changed_full in copy_this
- neuer Admintext mit unterstützen Bildformate
- Kontrolle der hochgeladenen Datei für das Wasserzeichen
- Korrektur der Hilfe-Links
- zusätzliche Überarbeitung für PHP 5.4
- changelog eingeführt

---

## 2.0.0.1
- Korrektur der automatischen Installation

---

## 2.0.0.0

**Minor version upgrade notice: there are some backward-incompatible changes to this release.**

- Umstrukturierung für Oxid 4.7 / 5.0
