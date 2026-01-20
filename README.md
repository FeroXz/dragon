# Dragon

**Version:** 0.3.0

## Überblick
Ein einfaches PHP-Projekt mit SQLite-Datenbank, Routing und Beispiel-Templates.

## Installation
1. PHP 8+ installieren.
2. Repository klonen und in das Projektverzeichnis wechseln.

## DB-Setup
Die SQLite-Datenbank wird beim ersten Aufruf automatisch unter `data/app.sqlite` erstellt und migriert.

## Start
```bash
php -S localhost:8000 -t public
```
Dann im Browser öffnen: `http://localhost:8000/?page=home`.

## Funktions-Checkliste
- [x] Projektstruktur (`public/`, `src/`, `data/`, `templates/`) angelegt.
- [x] Zentrales Einstiegsskript `public/index.php` erstellt.
- [x] Einfaches Routing mit Controller-Funktionen (Startseite, Seitenliste, News, Login, Adminbereich).
- [x] SQLite-DB-Initialisierung mit Migrationen für `users`, `pages`, `news`.
- [x] Seitenverwaltung (Admin-CRUD).
- [x] News-Modul (Liste, Detailansicht, Admin-CRUD inkl. Veröffentlichung/Entwurf).
- [x] Login/Logout mit Passwort-Hashing und Session-Auth.
- [x] Admin-Routen mit Auth-Check geschützt.
- [x] Admin-Dashboard-Ansicht ergänzt.
- [x] Initialer Admin-User per Seeder erstellt.
