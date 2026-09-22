<?php
/**
 * Plugin Name:       PC’L Übersetzungen für FluentAuth
 * Plugin URI:        https://github.com/blocoder/pcl-fauth-de
 * Update URI:        https://github.com/blocoder/pcl-fauth-de
 * Description:       Liefert die deutsche Übersetzung für FluentAuth aus (de_DE, Du-Fassung). Lädt sie vor allen anderen Katalogen und hält fremde deutsche Kataloge fern. Ergänzt vier Texte der Verwaltung, die FluentAuth nicht übersetzbar macht, übersetzt die feste Fußzeile der Code-Mails und verhindert, dass Mail-Apps den Anmeldecode als Telefonnummer verlinken. Der Katalog wird nur geladen, wenn FluentAuth installiert ist.
 * Version:           1.4.1
 * Requires at least: 6.5
 * Requires PHP:      7.4
 * Author:            Peter Claus Lamprecht (PC’L)
 * Author URI:        https://barmbek-nerd.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pcl-fluentauth-de
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

// Seit 1.1.0: fehlende Einträge der Übersetzungs-Map der Verwaltung.
require_once __DIR__ . '/map-de.php';

// Seit 1.2.0: Fußzeile und Anmeldecode in den Mails von FluentAuth.
require_once __DIR__ . '/mail-de.php';

/**
 * Seit 1.3.0: Updates kommen aus den GitHub-Releases.
 *
 * Mitgeliefert ist `plugin-update-checker` 5.7 (MIT, Jānis Elsts), wie in
 * `pcl-fluent-de`. Die Bibliothek liest das neueste Release des öffentlichen
 * Repos `blocoder/pcl-fauth-de`, nimmt die Versionsnummer aus dem Tag-Namen
 * (`v1.3.0` → `1.3.0`) und lädt das angehängte ZIP. Vorabversionen
 * überspringt sie. Repo und Plugin-Ordner heißen verschieden
 * (`pcl-fauth-de` gegenüber `pcl-fluentauth-de`); maßgeblich für die
 * Bibliothek ist der dritte Parameter, der Ordnername.
 *
 * Der Header `Update URI` steht trotzdem im Kopf. Ohne ihn fragt WordPress
 * für jedes Plugin bei wordpress.org nach; läge dort je ein Plugin mit dem
 * Ordnernamen `pcl-fluentauth-de`, bekäme diese Installation dessen Update.
 *
 * Keine Signatur- oder Prüfsummenkontrolle: WordPress wendet
 * `verify_file_signature()` nur auf Downloads von wordpress.org an. Was
 * schützt, ist HTTPS und GitHub (dieselbe Entscheidung wie bei
 * `pcl-fluent-de`).
 */
require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

add_action('init', function () {
    // Only on `init`: the library prints translated messages, and WordPress
    // 6.7+ complains about any earlier load_textdomain().
    $pruefer = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/blocoder/pcl-fauth-de/',
        __FILE__,
        'pcl-fluentauth-de'
    );

    // Without this the library downloads the source tarball - the repo with
    // the .po but without the .mo and .l10n.php that only package.sh builds.
    // An update from it would install a plugin without translation.
    $pruefer->getVcsApi()->enableReleaseAssets('/\.zip($|[?&#])/i');
});

/**
 * Warum dieses Plugin?
 *
 * Dasselbe Verfahren wie `pcl-fluentsmtp-de`, `pcl-fluentcrm-de` und
 * `pcl-fluent-de`: Der Katalog liegt im Plugin, wird auf `plugins_loaded`
 * mit Priorität 1 geladen und gewinnt damit gegen jede spätere Datei
 * derselben Textdomain. WP_Translation_Controller nimmt die erste Datei, die
 * einen String kennt.
 *
 * FluentAuth (Plugin-Ordner und Textdomain `fluent-security`) ruft beim
 * Einbinden load_plugin_textdomain() auf. Seit WordPress 6.7 registriert das
 * nur den Pfad; geladen wird erst beim ersten __(). Der frühe Ladeweg hier
 * greift also wie bei FluentSMTP.
 *
 * Nur die Du-Fassung (Entscheidung PC’L, 17.09.2026). Unter `de_DE_formal`
 * oder einer anderen Sprache lädt das Plugin nichts; es weicht bewusst nicht
 * auf die Du-Datei aus, damit eine Sie-Seite keine geduzte Anmeldeseite
 * bekommt.
 *
 * Fremde deutsche Kataloge werden ferngehalten. Ein Sprachpaket von
 * wordpress.org gibt es für FluentAuth am 17.09.2026 nicht (de_DE zu 2 %
 * übersetzt); der Riegel steht trotzdem, damit ein späteres Paket keine
 * bewusst offene Stelle füllt und keine zweite Terminologie mitbringt.
 *
 * Eine Sperre in `pcl-fluent-de` gab es für `fluent-security` nie.
 */

/**
 * Die Textdomains, für die dieses Plugin Kataloge mitbringt.
 *
 * Schlüssel ist die Textdomain, Wert der Ordnername unter wp-content/plugins/.
 */
function pcl_fluentauth_de_domains() {
    return apply_filters('pcl_fluentauth_de/domains', array(
        'fluent-security' => 'fluent-security',
    ));
}

/**
 * Normalisiert die Domain-Map. Eine Filter-Rückgabe kann eine reine Liste
 * sein; dann ist der Schlüssel numerisch und Domain gleich Ordnername.
 */
function pcl_fluentauth_de_domain_map() {
    $map = array();
    foreach ((array) pcl_fluentauth_de_domains() as $domain => $slug) {
        $map[is_int($domain) ? $slug : $domain] = $slug;
    }
    return $map;
}

function pcl_fluentauth_de_languages_dir() {
    return plugin_dir_path(__FILE__) . 'languages/';
}

/**
 * Lädt den eigenen Katalog, bevor irgendjemand anders ihn anfordert.
 *
 * @param string $locale Optional. Leer heißt: die gerade gültige Locale. Beim
 *                       Hook `change_locale` reicht WordPress die neue herein.
 */
function pcl_fluentauth_de_load($locale = '') {
    $locale = $locale ? $locale : determine_locale();
    $dir    = pcl_fluentauth_de_languages_dir();

    foreach (pcl_fluentauth_de_domain_map() as $domain => $slug) {
        // Kein Katalog für ein Plugin laden, das gar nicht da ist.
        if (!is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
            continue;
        }

        $eigen = $dir . $domain . '-' . $locale . '.mo';

        if (!is_readable($eigen)) {
            continue;
        }

        // load_textdomain() statt load_plugin_textdomain(): Letzteres sähe
        // zuerst in WP_LANG_DIR nach und stellte genau die Reihenfolge her,
        // die hier vermieden werden soll.
        load_textdomain($domain, $eigen, $locale);
    }
}
add_action('plugins_loaded', 'pcl_fluentauth_de_load', 1);

/**
 * Und noch einmal, wenn WordPress mitten im Lauf die Sprache wechselt.
 *
 * Beim Wechsel verwirft WordPress die geladenen Kataloge und lädt neu, aber
 * nur aus WP_LANG_DIR und dem Domain Path des jeweiligen Plugins. Unser
 * languages/-Ordner gehört zu keinem davon; ohne diesen Hook fiele FluentAuth
 * nach `switch_to_locale()` auf Englisch zurück (FluentCart-Projekt,
 * 03.08.2026). Bei FluentAuth betrifft das Mails in der Sprache des
 * Empfängers (Anmeldelink, Codes, Benachrichtigungen).
 */
add_action('change_locale', 'pcl_fluentauth_de_load', 1);

/**
 * Fremde deutsche Kataloge für unsere Domain nicht laden lassen.
 *
 * load_textdomain() fragt diesen Filter vor dem Lesen. `true` heißt „ist
 * erledigt“: Die Datei wird nicht gelesen. Getroffen werden nur Dateien
 * unserer Domain, deren Name auf eine deutsche Locale lautet und die nicht
 * aus unserem languages/-Ordner kommen – ein Sprachpaket in WP_LANG_DIR und
 * Locos Ordner. Andere Sprachen bleiben unberührt.
 *
 * Abschaltbar über `pcl_fluentauth_de/keep_foreign_german`.
 */
function pcl_fluentauth_de_block_foreign($override, $domain, $mofile = '') {
    if ($override || !$mofile) {
        return $override;
    }

    $map = pcl_fluentauth_de_domain_map();
    if (!isset($map[$domain])) {
        return $override;
    }

    $name = basename($mofile);
    if (strpos($name, $domain . '-de_') !== 0) {
        return $override;
    }

    $eigen = wp_normalize_path(pcl_fluentauth_de_languages_dir());
    if (strpos(wp_normalize_path($mofile), $eigen) === 0) {
        return $override;
    }

    if (apply_filters('pcl_fluentauth_de/keep_foreign_german', false, $domain, $mofile)) {
        return $override;
    }

    return true;
}
add_filter('override_load_textdomain', 'pcl_fluentauth_de_block_foreign', 1, 3);

/* -------------------------------------------------------------------------
 * Quellcode-Installation erkennen
 * ---------------------------------------------------------------------- */

/**
 * Stammt dieses Plugin aus dem Quellcode-Archiv statt aus dem Release?
 *
 * Im Repo stehen nur die `.po`; `.mo` und `.l10n.php` entstehen beim Bauen und
 * liegen allein im Release-Archiv. Wer auf der Repo-Startseite „Code → Download
 * ZIP“ nimmt, bekommt deshalb ein Plugin, das vollständig aussieht – der Ordner
 * `languages/` ist ja gefüllt – und trotzdem nichts übersetzt. Von außen ist
 * das nicht zu sehen; gemeldet von einem Nutzer am 20.09.2026, bei drei von
 * vier Plugins auf einmal.
 *
 * Erkennungszeichen ist der Ordner als Ganzes, nicht die Datei zur aktuellen
 * Locale: mindestens eine `.po`, aber kein einziger gebauter Katalog. Eine
 * fehlende Datei zu genau einer Locale ist etwas anderes und hat ihren eigenen
 * Hinweis.
 *
 * Kein `glob()`: Eckige Klammern im Installationspfad wären dort ein Muster.
 */
function pcl_fluentauth_de_quellinstallation() {
    static $ergebnis = null;

    if (null !== $ergebnis) {
        return $ergebnis;
    }

    $ergebnis = false;
    $dir      = pcl_fluentauth_de_languages_dir();

    if (!is_dir($dir)) {
        return $ergebnis;
    }

    $dateien = scandir($dir);

    if (!$dateien) {
        return $ergebnis;
    }

    $po = false;

    foreach ($dateien as $datei) {
        if (substr($datei, -3) === '.mo' || substr($datei, -9) === '.l10n.php') {
            return $ergebnis;
        }
        if (substr($datei, -3) === '.po') {
            $po = true;
        }
    }

    $ergebnis = $po;

    return $ergebnis;
}

/**
 * Der Link auf die Releases, aus denen das fertige Paket kommt.
 */
function pcl_fluentauth_de_release_link() {
    return sprintf(
        '<a href="https://github.com/blocoder/pcl-fauth-de/releases/latest" target="_blank" rel="noopener">%s</a>',
        esc_html__('Releases', 'pcl-fluentauth-de')
    );
}

/**
 * Hinweis im Backend, solange die gebauten Kataloge fehlen.
 *
 * Auf jeder Seite der Verwaltung und ohne Wegklicken: Das Plugin tut in diesem
 * Zustand gar nichts, und wer es installiert hat, merkt das sonst erst, wenn
 * ihm die englische Oberfläche auffällt. Zu sehen bekommt den Hinweis nur, wer
 * Plugins aktualisieren darf – alle anderen können ohnehin nichts ausrichten.
 */
function pcl_fluentauth_de_quellinstallation_hinweis() {
    if (!current_user_can('update_plugins') || !pcl_fluentauth_de_quellinstallation()) {
        return;
    }

    printf(
        '<div class="notice notice-warning"><p>%s</p></div>',
        wp_kses(
            sprintf(
                /* translators: %s: link to the releases page */
                __('<strong>PC’L Übersetzungen für FluentAuth:</strong> Die gebauten Kataloge fehlen, das Plugin übersetzt deshalb nichts. Es stammt offenbar aus dem Quellcode-Archiv von GitHub („Code → Download ZIP“); darin stehen nur die Ausgangsdateien. Bitte das ZIP aus den %s herunterladen und unter Plugins → Installieren → Plugin hochladen darüberspielen.', 'pcl-fluentauth-de'),
                pcl_fluentauth_de_release_link()
            ),
            array(
                'strong' => array(),
                'a'      => array('href' => array(), 'target' => array(), 'rel' => array()),
            )
        )
    );
}
add_action('admin_notices', 'pcl_fluentauth_de_quellinstallation_hinweis');

/**
 * Hinweis im Plugin-Verzeichnis, welche Kataloge tatsächlich greifen.
 *
 * Auf einer Seite mit `de_DE_formal` ist „Keine Kataloge“ die erwartete
 * Anzeige; ohne den Hinweis sähe das wie ein Fehler aus.
 */
function pcl_fluentauth_de_row_meta($links, $file) {
    if (plugin_basename(__FILE__) !== $file) {
        return $links;
    }

    // Fehlt der ganze Satz gebauter Kataloge, ist die Locale nicht die
    // Ursache. Dann hilft nur der Hinweis auf das Release-Archiv.
    if (pcl_fluentauth_de_quellinstallation()) {
        $links[] = sprintf(
            /* translators: %s: link to the releases page */
            __('Kompilierte Kataloge fehlen – aus dem Quellcode-Archiv installiert, bitte das ZIP aus den %s einspielen', 'pcl-fluentauth-de'),
            pcl_fluentauth_de_release_link()
        );

        return $links;
    }

    $locale  = determine_locale();
    $dir     = pcl_fluentauth_de_languages_dir();
    $geladen = array();
    $fehlend = array();

    foreach (pcl_fluentauth_de_domain_map() as $domain => $slug) {
        if (!is_dir(WP_PLUGIN_DIR . '/' . $slug)) {
            continue;
        }
        if (is_readable($dir . $domain . '-' . $locale . '.mo')) {
            $geladen[] = $domain;
        } else {
            $fehlend[] = $domain;
        }
    }

    $links[] = $geladen
        ? sprintf(
            /* translators: 1: locale, 2: comma separated list of text domains */
            esc_html__('Aktiv für %1$s: %2$s', 'pcl-fluentauth-de'),
            esc_html($locale),
            esc_html(implode(', ', $geladen))
        )
        : sprintf(
            /* translators: %s: locale */
            esc_html__('Keine Kataloge für %s (nur de_DE wird ausgeliefert)', 'pcl-fluentauth-de'),
            esc_html($locale)
        );

    if ($fehlend && $geladen) {
        $links[] = sprintf(
            /* translators: 1: comma separated list of text domains, 2: locale */
            esc_html__('Installiert, aber ohne Katalog: %1$s (keine Datei für %2$s)', 'pcl-fluentauth-de'),
            esc_html(implode(', ', $fehlend)),
            esc_html($locale)
        );
    }

    return $links;
}
add_filter('plugin_row_meta', 'pcl_fluentauth_de_row_meta', 10, 2);
