# PC’L Übersetzung für FluentAuth

Eine vollständige deutsche Übersetzung für **FluentAuth** (Anmeldung,
Zwei-Faktor, Passkeys, Sicherheitsscan) – ausgeliefert als WordPress-Plugin,
das seinen Katalog vor allen anderen lädt.

> Unabhängiges Projekt. Keine Verbindung zu WPManageNinja, den Herstellern
> von FluentAuth.

Stand: 17.09.2026, Version 1.3.0

---

## Warum eine eigene deutsche Übersetzung?

FluentAuth steuert auf meinen Seiten die Anmeldung: Anmeldeformular,
Anmeldecode per E-Mail, Passkeys, Zwei-Faktor-Einrichtung im Profil. Das sehen
nicht nur Administratoren, sondern alle Mitglieder. Mit Version 3.0 ist das
Plugin auf gut 1.900 Zeichenketten gewachsen, und auf translate.wordpress.org
waren davon 52 ins Deutsche übersetzt. Ein Sprachpaket gibt es deshalb nicht,
und die Oberfläche war englisch.

Dieses Plugin lädt seinen Katalog auf `plugins_loaded` mit Priorität 1, bevor
FluentAuth die erste Übersetzung anfordert. Wer zuerst lädt, gewinnt. Kommt
später ein Sprachpaket von wordpress.org dazu, hält das Plugin es fern, damit
nicht zwei Übersetzungen mit unterschiedlichen Begriffen auf derselben Seite
stehen.

---

## Was drin ist

| Katalog | FluentAuth-Version | übersetzt | offen |
|---|---|---:|---:|
| `fluent-security` | 3.0.1 | 1.903 | 10 |

FluentAuth heißt im Plugin-Ordner und in der Textdomain `fluent-security`.

**Die zehn offenen Einträge** bleiben mit Absicht englisch: Produkt- und
Anbieternamen (FluentAuth, Google, GitHub, Facebook), „Magic Login“ als Name
der Funktion, die Kopfzeilen des Plugins (Name, Adresse, Autor). Jede trägt
einen Übersetzerkommentar, warum sie leer steht.

Ein Katalog gehört zu einer Plugin-Version: Ändert der Hersteller einen
englischen Text, ist das für gettext ein neuer Schlüssel, und der alte fällt
aus dem Katalog. Auf einer älteren FluentAuth-Version erscheinen deshalb
einzelne Texte englisch. Auf FluentAuth 2.x fehlt ein großer Teil, weil 3.0
die Oberfläche neu geschrieben hat. Am besten erst FluentAuth aktualisieren,
dann dieses Plugin.

**Nur `de_DE`, in der Du-Form.** Eine Sie-Fassung gibt es nicht. Auf einer
Seite mit `de_DE_formal` lädt das Plugin absichtlich nichts, damit eine Seite
mit Sie-Anrede keine geduzte Anmeldeseite bekommt.

---

## Wie übersetzt wurde

**Du-Form mit großem „Du“.** Anmeldeseite, Profil und Mails sprechen
Mitglieder direkt an („Gib den Code aus Deiner Authenticator-App ein“). Die
Verwaltung bleibt knapp und kommt meist ohne Anrede aus.

**Begriffe wie im WordPress-Kern**, wo es sie dort gibt: *Anmelden*,
*Abmelden*, *Registrieren*, *Benutzer*, *Angemeldet bleiben*,
*Anwendungspasswörter*, *Must-Use-Plugins*. Für die neuen Dinge ein eigenes
Glossar:

| Englisch | Deutsch |
|---|---|
| Passkey | Passkey |
| Authenticator app | Authenticator-App |
| Two-Factor Authentication | Zwei-Faktor-Authentifizierung |
| Recovery codes | Wiederherstellungscodes |
| Magic link | Anmeldelink |
| Block / Blocked | sperren / gesperrt |
| Allow list / Block list | Positivliste / Sperrliste |
| Snapshot | Snapshot |
| Monitoring | Überwachung |

**Entstanden ist der Katalog mit KI-Unterstützung** (Claude), in Portionen und
gegen dieses Glossar. Danach liefen automatische Prüfungen über jede Zeile:
Platzhalter und HTML identisch mit dem Original, keine Sie-Formen, keine
Genderzeichen, typografische Anführungszeichen „…“ und das Auslassungszeichen
statt drei Punkten. Uneinheitliche Begriffe habe ich anschließend
vereinheitlicht und die sichtbaren Stellen auf echten Seiten angesehen:
Anmeldeformular, Verwaltung, die Mail mit dem Anmeldecode am Handy.

FluentAuth schreibt nummerierte Platzhalter als `%1s`, `%2s` (ohne `$`). Das
ist kein Fehler im Katalog, die Oberfläche ersetzt sie genau so.

---

## Was das Plugin außerdem tut

**Es ergänzt vier Texte der Verwaltung**, die FluentAuth 3.0.1 anzeigt, aber
nicht übersetzbar macht (unter anderem die Beschreibung der Passkey-Anmeldung).
Sie fehlen in FluentAuths Übersetzungsliste für die Oberfläche. Das Plugin
trägt sie über den Filter `fluent_security/app_vars` nach, nur solange
FluentAuth sie nicht selbst liefert. Gemeldet ist das beim Hersteller
([Issue 96](https://github.com/WPManageNinja/fluent-security/issues/96)).

**Es korrigiert die Mail mit dem Anmeldecode.** Die Fußzeile „This email has
been sent from: …“ steht fest in FluentAuths Vorlage und wird zu „Diese
E-Mail wurde gesendet von: …“. Außerdem machen Mail-Apps auf dem Handy aus
dem sechsstelligen Code gern einen Anruf-Link. Das Plugin setzt jede Ziffer in
ein eigenes Element und gibt der Mail die Anweisung mit, Telefonnummern nicht
zu erkennen. Ein kopierter Code bleibt dabei genau die sechs Ziffern. Andere
Mails der Seite bleiben unberührt.

**Es meldet Updates selbst.** Neue Versionen kommen aus den Releases dieses
Repos und erscheinen im Backend wie jedes andere Plugin-Update.

Alles lässt sich abschalten:

```php
add_filter( 'pcl_fluentauth_de/map_ergaenzen', '__return_false' );       // Verwaltung nicht ergänzen
add_filter( 'pcl_fluentauth_de/mail_korrigieren', '__return_false' );    // Mails unverändert lassen
add_filter( 'pcl_fluentauth_de/keep_foreign_german', '__return_true' );  // fremde Kataloge als Lückenfüller zulassen
```

---

## Installation

1. Das ZIP aus [Releases](https://github.com/blocoder/pcl-fauth-de/releases)
   herunterladen (`pcl-fluentauth-de-<version>.zip`).
2. Im Backend unter *Plugins → Installieren → Plugin hochladen* einspielen und
   aktivieren.

Die Seite muss auf `de_DE` stehen. In der Plugin-Liste steht danach, ob der
Katalog greift – das erspart die Suche, wenn die Sprache nicht passt.

Das Plugin heißt im Ordner `pcl-fluentauth-de`, das Repo `pcl-fauth-de`.

**Voraussetzungen:** WordPress 6.5+, PHP 7.4+, FluentAuth 3.0.1.

---

## Mitmachen

Ein Wort, das nicht passt? Eine Zeichenkette, die im Zusammenhang falsch
klingt? [Ein Issue](https://github.com/blocoder/pcl-fauth-de/issues) mit dem
englischen Original und der Stelle, an der es auftaucht, hilft am meisten.

Die `.po`-Datei liegt in `languages/` und lässt sich direkt bearbeiten, auch
mit Loco Translate im Backend – dafür ist die `loco.xml` da. Die kompilierten
`.mo`- und `.l10n.php`-Dateien stehen nur im Release-Archiv, nicht im Repo: Sie
sind Erzeugnisse.

---

## Lizenz

`GPL-2.0-or-later`, siehe [LICENSE](LICENSE).

Der Katalog enthält die Quellzeichenketten von FluentAuth und ist damit ein
abgeleitetes Werk GPL-lizenzierter Software. Nutzung, Änderung und Weitergabe
sind erlaubt, kommerziell eingeschlossen.

Mitgeliefert ist [plugin-update-checker](https://github.com/YahnisElsts/plugin-update-checker)
von Jānis Elsts (MIT-Lizenz, siehe `plugin-update-checker/license.txt`).

Namensnennung freut mich, ist aber keine Bedingung.
