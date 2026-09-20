=== PC'L Übersetzung für FluentAuth ===
Contributors: blocoder
Tags: fluentauth, fluent-security, deutsch, übersetzung, 2fa
Requires at least: 6.5
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.4.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Eine vollständige deutsche Übersetzung für FluentAuth (Du-Form) – als Plugin, das seinen Katalog vor allen anderen lädt.

== Description ==

1.938 übersetzte Zeichenketten für FluentAuth 3.0.3, ausgeliefert als eigenes Plugin statt über Loco Translate.

**Warum das nötig ist:** WordPress fragt für eine Textdomain mehrere Kataloge der Reihe nach ab und nimmt die erste Datei, die eine Zeichenkette kennt. Dieses Plugin lädt auf `plugins_loaded` mit Priorität 1 und hält fremde deutsche Kataloge fern. Ein Sprachpaket von wordpress.org gibt es für FluentAuth bisher nicht.

**Was sonst englisch bliebe:** Vier Texte der Verwaltung fehlen in FluentAuths Übersetzungsliste; das Plugin ergänzt sie. Die Mail mit dem Anmeldecode bekommt eine deutsche Fußzeile, und der Code wird auf Mobilgeräten nicht mehr als Telefonnummer verlinkt.

**Wie übersetzt wurde:** Du-Form mit großem „Du“. Anmeldeseite und Mails sprechen Mitglieder direkt an, die Verwaltung bleibt knapp. Begriffe wie im WordPress-Kern: Anmelden, Benutzer, Anwendungspasswörter.

Unabhängiges Projekt, keine Verbindung zu WPManageNinja.

== Installation ==

1. Das ZIP aus den GitHub-Releases herunterladen – aus dem Bereich „Releases“, nicht über „Code → Download ZIP“. Im Quellcode-Archiv fehlen die gebauten Kataloge.
2. Im Backend unter Plugins → Installieren → Plugin hochladen einspielen und aktivieren.

Die Seite muss auf `de_DE` stehen. Ab Version 1.3.0 meldet sich jedes weitere Update von selbst.

== Frequently Asked Questions ==

= Gibt es eine Sie-Fassung? =

Nein, nur `de_DE` in der Du-Form. Unter `de_DE_formal` lädt das Plugin nichts, damit eine Seite mit Sie-Anrede keine geduzte Anmeldeseite bekommt.

= Warum erscheinen einzelne Texte englisch? =

Ein Katalog gehört zu einer Plugin-Version. Ändert der Hersteller einen englischen Text, ist das für gettext ein neuer Schlüssel, und der alte fällt aus dem Katalog. Am besten erst FluentAuth aktualisieren, dann dieses Plugin.

= Wird das Paket auf Echtheit geprüft? =

Nein. WordPress bringt dafür einen Rahmen mit, wendet ihn aber nur auf Downloads von wordpress.org an. Was das Paket schützt, ist HTTPS und GitHub.

== Changelog ==

= 1.4.0 =
* Angepasst an FluentAuth 3.0.3: 109 neue Zeichenketten, 50 entfallene. Der Hersteller hat seine englischen Texte überarbeitet – erst FluentAuth aktualisieren, dann dieses Plugin.
* Produktnamen und Menüpfade der erkannten Fremd-Plugins für Zwei-Faktor-Anmeldung bleiben englisch.

= 1.3.1 =
* Hinweis in der Verwaltung und in der Plugin-Liste, wenn das Plugin aus dem Quellcode-Archiv statt aus den Releases installiert wurde und die gebauten Kataloge deshalb fehlen.

= 1.3.0 =
* Das Plugin meldet Updates jetzt selbst und holt sie von GitHub.
* Erste öffentliche Fassung. Übersetzungen unverändert.

= 1.2.1 =
* Der Link nach dem Hinweis auf den Anmeldecode heißt „Weiter zur Code-Eingabe“.

= 1.2.0 =
* Mail mit dem Anmeldecode: deutsche Fußzeile, der Code wird nicht mehr als Telefonnummer verlinkt.
* Menüpunkt „Anmeldung/Registrierung“ statt „Anmelde- und Registrierungsformulare“.

= 1.1.0 =
* Vier Texte der Verwaltung ergänzt, die FluentAuth nicht übersetzbar macht.

= 1.0.0 =
* Erste Fassung, abgeglichen mit FluentAuth 3.0.1.
