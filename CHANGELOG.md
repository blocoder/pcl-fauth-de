# Änderungen

Die Versionsnummer steigt bei **jeder** Katalogänderung, auch wenn sich am
Plugin-Code nichts tut. Ein Archiv, dessen Name nichts über seinen Inhalt
sagt, ist beim Weitergeben wertlos.

## 1.3.1

**Ein Hinweis, wenn die gebauten Kataloge fehlen.** Wer das Plugin aus dem
Quellcode-Archiv von GitHub installiert („Code → Download ZIP“) statt aus den
Releases, bekommt nur die `.po`-Dateien und damit ein Plugin, das nichts
übersetzt. Von außen war das nicht zu erkennen – die Plugin-Liste meldete
lediglich „Keine Kataloge gefunden“, was nach einem Problem mit der Sprache
aussieht. Jetzt benennt das Plugin die Ursache, in der Plugin-Liste und als
Hinweis in der Verwaltung, samt Link auf das richtige Archiv.

An den Katalogen ändert sich nichts.

## 1.3.0

Erste öffentliche Fassung. Das Plugin meldet Updates jetzt selbst und holt sie
aus den Releases dieses Repos. Übersetzungen unverändert.

**Die erste Fassung mit Update-Funktion muss von Hand eingespielt werden.**
Frühere Versionen kennen sie nicht; ab 1.3.0 meldet sich jede weitere von
selbst.

## 1.2.1

Der Link nach dem Hinweis auf den Anmeldecode heißt „Weiter zur Code-Eingabe“
statt „Anmeldung abschließen“.

## 1.2.0

**Mail mit dem Anmeldecode:** Die fest eingebaute Fußzeile „This email has
been sent from: …“ erscheint deutsch. Der Code wird auf Mobilgeräten nicht
mehr als Telefonnummer verlinkt: Jede Ziffer steht in einem eigenen Element,
dazu die Anweisung `format-detection` im Kopf der Mail. Betroffen sind nur
Mails von FluentAuth.

Der Menüpunkt heißt „Anmeldung/Registrierung“ statt „Anmelde- und
Registrierungsformulare“, der lange Name wurde in der Seitenleiste
abgeschnitten.

## 1.1.0

Vier Texte der Verwaltung ergänzt, die FluentAuth 3.0.1 anzeigt, aber nicht
in seiner Übersetzungsliste führt – unter anderem die Beschreibung der
Passkey-Anmeldung. Die Ergänzung tritt zurück, sobald FluentAuth die Texte
selbst liefert.

## 1.0.0

Erste Fassung: 1.903 von 1.913 Zeichenketten, abgeglichen mit FluentAuth
3.0.1. Nur `de_DE`, Du-Form.
