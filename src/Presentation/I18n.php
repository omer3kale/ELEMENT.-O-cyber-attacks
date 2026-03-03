<?php

declare(strict_types=1);

namespace ElementO\Presentation;

/**
 * Central i18n table for all UI strings across the catalog and docs pages.
 *
 * - LANGS:         the three supported languages.
 * - KEYS:          the single source of truth; every key must be present in $tr.
 * - t(key, lang):  returns the translated string (falls back to 'en' if a lang entry is missing).
 * - i(key):        returns a data-i18n-key="…" data-i18n-en="…" data-i18n-tr="…" data-i18n-de="…" attribute string.
 * - assertComplete(): throws RuntimeException for any missing translation; call during build.
 */
final class I18n
{
    public const LANGS = ['en', 'tr', 'de'];

    public const KEYS = [
        // ── Catalog UI ────────────────────────────────────────────────
        'catalog_title',
        'view_details',
        'example_vectors',
        'close',
        'mitre_label',
        'impact_label',
        'platforms_label',
        'risk_label',
        'risk_stat',
        'success_rate',
        'privilege',
        'description',
        'target_profile',
        'delivery',
        'method_label',
        'avg_impact',
        'kill_chain',
        'detection_mit',
        'detection_diff',
        'tools_used',
        'cve_references',
        'data_sources',
        'mitigations',
        'real_world',
        'year_label',
        'victim_label',
        'impact_case',
        'attribution_label',
        'notes',

        // ── Docs — navigation ─────────────────────────────────────────
        'nav_home',
        'nav_attacks',
        'nav_scheduler',
        'nav_security_tasks',
        'nav_multi_tenant',
        'nav_view_catalog',
        'nav_github',

        // ── Docs — page titles (short, single-line h1) ─────────────────
        'page_title_attacks',
        'page_title_scheduler',
        'page_title_security_tasks',
        'page_title_multi_tenant',

        // ── Docs — CTA buttons ────────────────────────────────────────
        'btn_how_tasks',
        'btn_browse_catalog',
        'btn_live_catalog',
        'btn_how_attacks_tasks',
        'btn_add_multi_tenant',
        'btn_see_catalog',
        'btn_open_catalog',
        'btn_view_github',

        // ── Docs — section headings (reusable across pages) ───────────
        'section_three_modules',
        'section_safety_question',
        'section_two_directions',
    ];

    /** @var array<string, array<string, string>> */
    private static array $tr = [
        // ── Catalog UI ────────────────────────────────────────────────
        'catalog_title'        => ['en' => 'ELEMENT.İO / Cyber Attack Catalogue',   'tr' => 'ELEMENT.İO / Siber Saldırı Kataloğu',    'de' => 'ELEMENT.İO / Katalog für Cyberangriffe'],
        'view_details'         => ['en' => 'View details',                            'tr' => 'Detayları gör',                           'de' => 'Details anzeigen'],
        'example_vectors'      => ['en' => 'Example vectors (safe)',                  'tr' => 'Örnek vektörler (güvenli)',               'de' => 'Beispielvektoren (sicher)'],
        'close'                => ['en' => 'Close',                                   'tr' => 'Kapat',                                   'de' => 'Schließen'],
        'mitre_label'          => ['en' => 'MITRE:',                                  'tr' => 'MITRE:',                                  'de' => 'MITRE:'],
        'impact_label'         => ['en' => 'Impact:',                                 'tr' => 'Etki:',                                   'de' => 'Auswirkung:'],
        'platforms_label'      => ['en' => 'Platforms:',                              'tr' => 'Platformlar:',                            'de' => 'Plattformen:'],
        'risk_label'           => ['en' => 'Risk',                                    'tr' => 'Risk',                                    'de' => 'Risiko'],
        'risk_stat'            => ['en' => 'Risk:',                                   'tr' => 'Risk:',                                   'de' => 'Risiko:'],
        'success_rate'         => ['en' => 'Success rate:',                           'tr' => 'Başarı oranı:',                           'de' => 'Erfolgsrate:'],
        'privilege'            => ['en' => 'Privilege:',                              'tr' => 'Yetki:',                                  'de' => 'Berechtigung:'],
        'description'          => ['en' => 'Description',                             'tr' => 'Açıklama',                                'de' => 'Beschreibung'],
        'target_profile'       => ['en' => 'Target profile',                          'tr' => 'Hedef profili',                           'de' => 'Zielprofil'],
        'delivery'             => ['en' => 'Delivery',                                'tr' => 'Dağıtım',                                 'de' => 'Übermittlung'],
        'method_label'         => ['en' => 'Method:',                                 'tr' => 'Yöntem:',                                 'de' => 'Methode:'],
        'avg_impact'           => ['en' => 'Average impact:',                         'tr' => 'Ortalama etki:',                          'de' => 'Durchschn. Auswirkung:'],
        'kill_chain'           => ['en' => 'Kill chain phase:',                       'tr' => 'Kill chain aşaması:',                     'de' => 'Kill-Chain-Phase:'],
        'detection_mit'        => ['en' => 'Detection &amp; mitigations',             'tr' => 'Tespit &amp; azaltma',                    'de' => 'Erkennung &amp; Gegenmaßnahmen'],
        'detection_diff'       => ['en' => 'Detection difficulty:',                   'tr' => 'Tespit zorluğu:',                         'de' => 'Erkennungsschwierigkeit:'],
        'tools_used'           => ['en' => 'Tools used',                              'tr' => 'Kullanılan araçlar',                      'de' => 'Verwendete Tools'],
        'cve_references'       => ['en' => 'CVE references',                          'tr' => 'CVE referansları',                        'de' => 'CVE-Referenzen'],
        'data_sources'         => ['en' => 'Data sources',                            'tr' => 'Veri kaynakları',                         'de' => 'Datenquellen'],
        'mitigations'          => ['en' => 'Mitigations',                             'tr' => 'Azaltma önlemleri',                       'de' => 'Gegenmaßnahmen'],
        'real_world'           => ['en' => 'Real-world case',                         'tr' => 'Gerçek dünya vakası',                     'de' => 'Realer Vorfall'],
        'year_label'           => ['en' => 'Year:',                                   'tr' => 'Yıl:',                                    'de' => 'Jahr:'],
        'victim_label'         => ['en' => 'Victim:',                                 'tr' => 'Mağdur:',                                 'de' => 'Opfer:'],
        'impact_case'          => ['en' => 'Impact:',                                 'tr' => 'Etki:',                                   'de' => 'Auswirkung:'],
        'attribution_label'    => ['en' => 'Attribution:',                            'tr' => 'Atıf:',                                   'de' => 'Zuschreibung:'],
        'notes'                => ['en' => 'Notes',                                   'tr' => 'Notlar',                                  'de' => 'Hinweise'],

        // ── Docs — navigation ─────────────────────────────────────────
        'nav_home'             => ['en' => 'Home',                                    'tr' => 'Ana Sayfa',                               'de' => 'Startseite'],
        'nav_attacks'          => ['en' => 'Attacks',                                 'tr' => 'Saldırılar',                              'de' => 'Angriffe'],
        'nav_scheduler'        => ['en' => 'Scheduler',                               'tr' => 'Zamanlayıcı',                             'de' => 'Scheduler'],
        'nav_security_tasks'   => ['en' => 'Security Tasks',                          'tr' => 'Güvenlik Görevleri',                      'de' => 'Sicherheitsaufgaben'],
        'nav_multi_tenant'     => ['en' => 'Multi-Tenant',                            'tr' => 'Çok Kiracılı',                            'de' => 'Mandantenfähig'],
        'nav_view_catalog'     => ['en' => 'View Catalog →',                          'tr' => 'Kataloğu Görüntüle →',                    'de' => 'Katalog anzeigen →'],
        'nav_github'           => ['en' => 'GitHub ↗',                                'tr' => 'GitHub ↗',                                'de' => 'GitHub ↗'],

        // ── Docs — page titles ────────────────────────────────────────
        'page_title_attacks'        => ['en' => 'Attack Catalog',                     'tr' => 'Saldırı Kataloğu',                        'de' => 'Angriffskatalog'],
        'page_title_scheduler'      => ['en' => 'Scheduler',                          'tr' => 'Zamanlayıcı',                             'de' => 'Scheduler'],
        'page_title_security_tasks' => ['en' => 'Security Task Generator',            'tr' => 'Güvenlik Görevi Oluşturucu',              'de' => 'Sicherheitsaufgaben-Generator'],
        'page_title_multi_tenant'   => ['en' => 'Multi-Tenant Architecture',          'tr' => 'Çok Kiracılı Mimari',                     'de' => 'Mandantenfähige Architektur'],

        // ── Docs — CTA buttons ────────────────────────────────────────
        'btn_how_tasks'        => ['en' => 'How Tasks Are Generated →',               'tr' => 'Görevler Nasıl Oluşturulur →',            'de' => 'Wie Aufgaben erstellt werden →'],
        'btn_browse_catalog'   => ['en' => 'Browse the Attack Catalog',               'tr' => 'Saldırı Kataloğunu İncele',               'de' => 'Angriffskatalog durchsuchen'],
        'btn_live_catalog'     => ['en' => 'Browse the Live Catalog →',               'tr' => 'Canlı Kataloğu İncele →',                 'de' => 'Live-Katalog durchsuchen →'],
        'btn_how_attacks_tasks'=> ['en' => 'How Attacks Become Tasks',                'tr' => 'Saldırılar Nasıl Göreve Dönüşür',         'de' => 'Wie Angriffe zu Aufgaben werden'],
        'btn_add_multi_tenant' => ['en' => 'Add Multi-Tenant →',                      'tr' => 'Çok Kiracılı Ekle →',                     'de' => 'Multi-Tenant hinzufügen →'],
        'btn_see_catalog'      => ['en' => 'See the Attack Catalog',                  'tr' => 'Saldırı Kataloğuna Bak',                  'de' => 'Angriffskatalog ansehen'],
        'btn_open_catalog'     => ['en' => 'Open the Attack Catalog →',               'tr' => 'Saldırı Kataloğunu Aç →',                 'de' => 'Angriffskatalog öffnen →'],
        'btn_view_github'      => ['en' => 'View on GitHub ↗',                        'tr' => 'GitHub\'da Görüntüle ↗',                  'de' => 'Auf GitHub ansehen ↗'],

        // ── Docs — section headings ───────────────────────────────────
        'section_three_modules'    => ['en' => 'Three modules, one pipeline',
                                       'tr' => 'Üç modül, bir boru hattı',
                                       'de' => 'Drei Module, eine Pipeline'],
        'section_safety_question'  => ['en' => 'How can you send harmless (mock) attacks to your coworkers?',
                                       'tr' => 'Zararsız (sahte) saldırıları iş arkadaşlarınıza nasıl gönderirsiniz?',
                                       'de' => 'Wie können harmlose (Mock-)Angriffe an Kollegen gesendet werden?'],
        'section_two_directions'   => ['en' => 'Two directions',
                                       'tr' => 'İki yön',
                                       'de' => 'Zwei Richtungen'],
    ];

    public static function t(string $key, string $lang): string
    {
        return self::$tr[$key][$lang] ?? self::$tr[$key]['en'] ?? $key;
    }

    public static function i(string $key): string
    {
        $parts = ['data-i18n-key="' . htmlspecialchars($key, ENT_QUOTES | ENT_HTML5, 'UTF-8') . '"'];
        foreach (self::LANGS as $lang) {
            $val    = self::t($key, $lang);
            $parts[] = 'data-i18n-' . $lang . '="' . htmlspecialchars($val, ENT_QUOTES | ENT_HTML5, 'UTF-8') . '"';
        }
        return implode(' ', $parts);
    }

    public static function assertComplete(): void
    {
        foreach (self::KEYS as $key) {
            foreach (self::LANGS as $lang) {
                if (!isset(self::$tr[$key][$lang])) {
                    throw new \RuntimeException(
                        "Missing i18n translation for key '{$key}' in '{$lang}'"
                    );
                }
            }
        }
    }
}
