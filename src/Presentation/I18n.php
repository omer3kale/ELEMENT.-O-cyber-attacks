<?php

declare(strict_types=1);

namespace ElementO\Presentation;

final class I18n
{
    public const LANGS = ['en', 'tr', 'de'];

    public const KEYS = [
        // Catalog UI 
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

        // Docs & navigation
        'nav_home',
        'nav_attacks',
        'nav_scheduler',
        'nav_security_tasks',
        'nav_multi_tenant',
        'nav_view_catalog',
        'nav_github',

        // Docs & page titles 
        'page_title_attacks',
        'page_title_scheduler',
        'page_title_security_tasks',
        'page_title_multi_tenant',

        // Docs & CTA buttons 
        'btn_how_tasks',
        'btn_browse_catalog',
        'btn_live_catalog',
        'btn_how_attacks_tasks',
        'btn_add_multi_tenant',
        'btn_see_catalog',
        'btn_open_catalog',
        'btn_view_github',

        // Docs section headings
        'section_three_modules',
        'section_safety_question',
        'section_two_directions',

        // Landing page — hero
        'landing_hero_title',
        'landing_hero_desc',

        // Landing page — section labels
        'landing_label_arch',
        'landing_label_team',
        'landing_label_roadmap',

        // Landing page — architecture section
        'landing_arch_sub',
        'landing_card_attacks_title',
        'landing_card_attacks_desc',
        'landing_card_scheduler_title',
        'landing_card_scheduler_desc',
        'landing_card_tasks_title',
        'landing_card_tasks_desc',

        // Landing page — team walkthrough
        'landing_team_sub',
        'landing_step1_title',
        'landing_step1_desc',
        'landing_step2_title',
        'landing_step2_desc',
        'landing_step3_title',
        'landing_step3_desc',

        // Landing page — roadmap cards
        'landing_dir1_title',
        'landing_dir1_desc',
        'landing_dir2_title',
        'landing_dir2_desc',
    ];

    /** @var array<string, array<string, string>> */
    private static array $tr = [
        // Catalog UI 
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

        // Docs & navigation 
        'nav_home'             => ['en' => 'Home',                                    'tr' => 'Ana Sayfa',                               'de' => 'Startseite'],
        'nav_attacks'          => ['en' => 'Attacks',                                 'tr' => 'Saldırılar',                              'de' => 'Angriffe'],
        'nav_scheduler'        => ['en' => 'Scheduler',                               'tr' => 'Zamanlayıcı',                             'de' => 'Scheduler'],
        'nav_security_tasks'   => ['en' => 'Security Tasks',                          'tr' => 'Güvenlik Görevleri',                      'de' => 'Sicherheitsaufgaben'],
        'nav_multi_tenant'     => ['en' => 'Multi-Tenant',                            'tr' => 'Çok Kiracılı',                            'de' => 'Mandantenfähig'],
        'nav_view_catalog'     => ['en' => 'View Catalog →',                          'tr' => 'Kataloğu Görüntüle →',                    'de' => 'Katalog anzeigen →'],
        'nav_github'           => ['en' => 'GitHub ↗',                                'tr' => 'GitHub ↗',                                'de' => 'GitHub ↗'],

        // Docs & page titles 
        'page_title_attacks'        => ['en' => 'Attack Catalog',                     'tr' => 'Saldırı Kataloğu',                        'de' => 'Angriffskatalog'],
        'page_title_scheduler'      => ['en' => 'Scheduler',                          'tr' => 'Zamanlayıcı',                             'de' => 'Scheduler'],
        'page_title_security_tasks' => ['en' => 'Security Task Generator',            'tr' => 'Güvenlik Görevi Oluşturucu',              'de' => 'Sicherheitsaufgaben-Generator'],
        'page_title_multi_tenant'   => ['en' => 'Multi-Tenant Architecture',          'tr' => 'Çok Kiracılı Mimari',                     'de' => 'Mandantenfähige Architektur'],

        // Docs & CTA buttons 
        'btn_how_tasks'        => ['en' => 'How Tasks Are Generated →',               'tr' => 'Görevler Nasıl Oluşturulur →',            'de' => 'Wie Aufgaben erstellt werden →'],
        'btn_browse_catalog'   => ['en' => 'Browse the Attack Catalog',               'tr' => 'Saldırı Kataloğunu İncele',               'de' => 'Angriffskatalog durchsuchen'],
        'btn_live_catalog'     => ['en' => 'Browse the Live Catalog →',               'tr' => 'Canlı Kataloğu İncele →',                 'de' => 'Live-Katalog durchsuchen →'],
        'btn_how_attacks_tasks'=> ['en' => 'How Attacks Become Tasks',                'tr' => 'Saldırılar Nasıl Göreve Dönüşür',         'de' => 'Wie Angriffe zu Aufgaben werden'],
        'btn_add_multi_tenant' => ['en' => 'Add Multi-Tenant →',                      'tr' => 'Çok Kiracılı Ekle →',                     'de' => 'Multi-Tenant hinzufügen →'],
        'btn_see_catalog'      => ['en' => 'See the Attack Catalog',                  'tr' => 'Saldırı Kataloğuna Bak',                  'de' => 'Angriffskatalog ansehen'],
        'btn_open_catalog'     => ['en' => 'Open the Attack Catalog →',               'tr' => 'Saldırı Kataloğunu Aç →',                 'de' => 'Angriffskatalog öffnen →'],
        'btn_view_github'      => ['en' => 'View on GitHub ↗',                        'tr' => 'GitHub\'da Görüntüle ↗',                  'de' => 'Auf GitHub ansehen ↗'],

        // Docs & section headings 
        'section_three_modules'    => ['en' => 'Three modules, one pipeline',
                                       'tr' => 'Üç modül, bir boru hattı',
                                       'de' => 'Drei Module, eine Pipeline'],
        'section_safety_question'  => ['en' => 'How can you send harmless (mock) attacks to your coworkers?',
                                       'tr' => 'Zararsız (sahte) saldırıları iş arkadaşlarınıza nasıl gönderirsiniz?',
                                       'de' => 'Wie können harmlose (Mock-)Angriffe an Kollegen gesendet werden?'],
        'section_two_directions'   => ['en' => 'Two directions',
                                       'tr' => 'İki yön',
                                       'de' => 'Zwei Richtungen'],

        // Landing page — hero
        'landing_hero_title' => [
            'en' => 'Turn your full threat catalog into scheduled, brand-tagged security work items — for any team, any tenant, in minutes.',
            'tr' => 'Tüm tehdit kataloğunuzu planlı, marka etiketli güvenlik iş öğelerine dönüştürün — her ekip, her kiracı için, dakikalar içinde.',
            'de' => 'Verwandeln Sie Ihren gesamten Bedrohungskatalog in geplante, markierte Sicherheitsaufgaben – für jedes Team, jeden Mandanten, in Minuten.',
        ],
        'landing_hero_desc'  => [
            'en' => 'ELEMENT.İO reads 30 structured attack definitions, schedules them as processable items respecting office hours and German public holidays, stamps them with your brand, and routes them to each analyst — all with a single PHP command and zero cloud dependencies.',
            'tr' => 'ELEMENT.İO, 30 yapılandırılmış saldırı tanımını okur; bunları mesai saatlerine ve Almanya\'nın resmi tatillerine saygı göstererek işlenebilir öğeler olarak planlar, markanızla damgalar ve her analize yönlendirir — tek bir PHP komutuyla, sıfır bulut bağımlılığıyla.',
            'de' => 'ELEMENT.İO liest 30 strukturierte Angriffsdefinitionen, plant sie als verarbeitbare Elemente unter Berücksichtigung von Bürozeiten und deutschen Feiertagen, versieht sie mit Ihrem Markenzeichen und leitet sie an jeden Analysten weiter – alles mit einem einzigen PHP-Befehl und ohne Cloud-Abhängigkeiten.',
        ],

        // Landing page — section labels
        'landing_label_arch'    => ['en' => 'Architecture in 30 seconds',   'tr' => '30 saniyede mimari',              'de' => 'Architektur in 30 Sekunden'],
        'landing_label_team'    => ['en' => 'For your team',                 'tr' => 'Ekibiniz için',                   'de' => 'Für Ihr Team'],
        'landing_label_roadmap' => ['en' => 'Where this can go next',        'tr' => 'Bundan sonra nereye gidebilir',   'de' => 'Wohin das als Nächstes führen kann'],

        // Landing page — architecture section
        'landing_arch_sub' => [
            'en' => 'Each module maps to a bounded context in the DDD layer; none depends on the others at the infrastructure level.',
            'tr' => 'Her modül, DDD katmanındaki bir sınırlı bağlama karşılık gelir; hiçbiri altyapı düzeyinde diğerlerine bağımlı değildir.',
            'de' => 'Jedes Modul entspricht einem Bounded Context in der DDD-Schicht; keines hängt auf Infrastrukturebene von den anderen ab.',
        ],
        'landing_card_attacks_title'   => ['en' => 'Attack Catalog',            'tr' => 'Saldırı Kataloğu',               'de' => 'Angriffskatalog'],
        'landing_card_attacks_desc'    => [
            'en' => '30 attacks across 12 categories defined in a custom .attack DSL and parsed by an ANTLR-based adapter into AttackAggregate domain objects. No live exploit payloads — structural threat modelling only.',
            'tr' => 'Özel .attack DSL\'i ile tanımlanmış 12 kategoride 30 saldırı, ANTLR tabanlı bir adaptör tarafından AttackAggregate domain nesnelerine çözümlenir. Canlı exploit yükü yok — yalnızca yapısal tehdit modellemesi.',
            'de' => '30 Angriffe in 12 Kategorien, definiert in einer eigenen .attack-DSL und von einem ANTLR-Adapter in AttackAggregate-Domänenobjekte geparst. Keine Live-Exploit-Payloads – nur strukturelle Bedrohungsmodellierung.',
        ],
        'landing_card_scheduler_title' => ['en' => 'Scheduler',                 'tr' => 'Zamanlayıcı',                    'de' => 'Scheduler'],
        'landing_card_scheduler_desc'  => [
            'en' => 'ProcessableItemsService distributes work items across a date range with three pluggable strategies — EVEN, RANDOM_SPACED, WEIGHTED — while honouring office hours and German public holidays.',
            'tr' => 'ProcessableItemsService, iş öğelerini bir tarih aralığına üç takılabilir stratejiyle dağıtır — EVEN, RANDOM_SPACED, WEIGHTED — mesai saatlerine ve Almanya\'nın resmi tatillerine saygı göstererek.',
            'de' => 'ProcessableItemsService verteilt Aufgaben über einen Datumsbereich mit drei austauschbaren Strategien – EVEN, RANDOM_SPACED, WEIGHTED – unter Berücksichtigung von Bürozeiten und deutschen Feiertagen.',
        ],
        'landing_card_tasks_title'     => ['en' => 'Security Task Generator',   'tr' => 'Güvenlik Görevi Oluşturucu',   'de' => 'Sicherheitsaufgaben-Generator'],
        'landing_card_tasks_desc'      => [
            'en' => 'SecurityTaskGenerator bridges the catalog and the scheduler. Each attack becomes a tagged, brand-prefixed task title like [ACME Bank] [SOCIAL-ENG] Run phishing simulation…',
            'tr' => 'SecurityTaskGenerator, katalog ile zamanlayıcı arasında köprü kurar. Her saldırı, [ACME Bank] [SOCIAL-ENG] Kimlik avı simülasyonu çalıştır… gibi etiketli, marka önekli bir görev başlığına dönüşür.',
            'de' => 'SecurityTaskGenerator verbindet den Katalog mit dem Scheduler. Jeder Angriff wird zu einem markierten, markenvorangestellten Aufgabentitel wie [ACME Bank] [SOCIAL-ENG] Phishing-Simulation durchführen…',
        ],

        // Landing page — team walkthrough
        'landing_team_sub'    => [
            'en' => 'No technical background needed. Here\'s how a team lead or exec can run a safe, fully controlled security awareness exercise in three steps.',
            'tr' => 'Teknik bir altyapıya gerek yok. Bir ekip lideri veya yöneticinin güvenli, tam kontrollü bir güvenlik farkındalık egzersizini üç adımda nasıl yürütebileceği aşağıda açıklanmıştır.',
            'de' => 'Kein technisches Hintergrundwissen erforderlich. So kann eine Führungskraft in drei Schritten eine sichere, vollständig kontrollierte Sicherheitsbewusstseinsübung durchführen.',
        ],
        'landing_step1_title' => ['en' => 'Pick your scenario from the catalog',     'tr' => 'Katalogdan senaryonuzu seçin',         'de' => 'Wählen Sie Ihr Szenario aus dem Katalog'],
        'landing_step1_desc'  => [
            'en' => 'Browse the Attack Catalog and choose a scenario that fits your team\'s risk profile — for example, a phishing email simulation or a fake USB-drop exercise. Every entry is a structured description, not a live exploit. Nothing harmful is sent until you deliberately trigger it.',
            'tr' => 'Saldırı Kataloğuna göz atın ve ekibinizin risk profiline uyan bir senaryo seçin — örneğin, bir kimlik avı e-posta simülasyonu veya sahte bir USB bırakma egzersizi. Her giriş, canlı bir exploit değil, yapılandırılmış bir açıklamadır. Siz kasıtlı olarak tetikleyene kadar zararlı hiçbir şey gönderilmez.',
            'de' => 'Durchsuchen Sie den Angriffskatalog und wählen Sie ein Szenario, das zum Risikoprofil Ihres Teams passt – z. B. eine Phishing-E-Mail-Simulation oder eine gefälschte USB-Drop-Übung. Jeder Eintrag ist eine strukturierte Beschreibung, kein Live-Exploit. Es wird nichts Schädliches gesendet, bis Sie es bewusst auslösen.',
        ],
        'landing_step2_title' => ['en' => 'Schedule it for your team\'s calendar',  'tr' => 'Ekibinizin takvimine planlayın',        'de' => 'Planen Sie es in den Teamkalender ein'],
        'landing_step2_desc'  => [
            'en' => 'The scheduler automatically spreads tasks across your analysts\' working hours, respecting lunch, public holidays, and minimum spacing between exercises — so nobody gets hit with three scenarios on a Monday morning. You choose the week, the number of tasks per person, and whether the timing is predictable or randomised (to better mimic real attacker behaviour).',
            'tr' => 'Zamanlayıcı, görevleri analistlerinizin çalışma saatlerine otomatik olarak yayar; öğle aralarına, resmi tatillere ve egzersizler arasındaki minimum aralığa saygı gösterir — böylece kimse Pazartesi sabahı üç senaryoyla karşılaşmaz. Haftayı, kişi başına görev sayısını ve zamanlamanın tahmin edilebilir mi yoksa rastgele mi olacağını siz seçersiniz.',
            'de' => 'Der Scheduler verteilt Aufgaben automatisch auf die Arbeitszeiten Ihrer Analysten, unter Berücksichtigung von Mittagspausen, Feiertagen und Mindestabständen zwischen Übungen – damit niemand am Montagmorgen mit drei Szenarien konfrontiert wird. Sie wählen die Woche, die Anzahl der Aufgaben pro Person und ob die Zeiteinteilung vorhersehbar oder zufällig ist.',
        ],
        'landing_step3_title' => ['en' => 'Your team receives a branded task — they respond', 'tr' => 'Ekibiniz markalı bir görev alır — yanıt verirler', 'de' => 'Ihr Team erhält eine Markenaufgabe — sie reagieren'],
        'landing_step3_desc'  => [
            'en' => 'Each team member gets a task titled with your company name and the attack category, e.g. [Acme Corp] [SOCIAL-ENG] Identify and report suspicious email. They treat it like any work ticket — investigate, respond, and mark it complete. You review who caught it and who missed it, with zero real risk to your systems.',
            'tr' => 'Her ekip üyesi, şirket adınız ve saldırı kategorisiyle başlıklı bir görev alır; ör. [Acme Corp] [SOCIAL-ENG] Şüpheli e-postayı tanımlayın ve bildirin. Bunu normal bir iş bileti gibi ele alırlar — soruşturur, yanıt verir ve tamamlandı olarak işaretlerler. Sistemlerinize sıfır gerçek risk ile kimin yakaladığını ve kimin kaçırdığını gözden geçirirsiniz.',
            'de' => 'Jedes Teammitglied erhält eine Aufgabe mit dem Namen Ihres Unternehmens und der Angriffskategorie, z. B. [Acme Corp] [SOCIAL-ENG] Verdächtige E-Mail identifizieren und melden. Sie behandeln sie wie jedes andere Arbeitsticket – untersuchen, reagieren und als erledigt markieren. Sie überprüfen, wer es erkannt und wer es verpasst hat, mit null realem Risiko für Ihre Systeme.',
        ],

        // Landing page — roadmap cards
        'landing_dir1_title' => ['en' => 'Support our services',                    'tr' => 'Hizmetlerimizi destekleyin',             'de' => 'Unsere Dienste unterstützen'],
        'landing_dir1_desc'  => [
            'en' => 'We run managed security awareness exercises for teams of all sizes. Reach out to schedule a demo, get a branded tenant set up, or discuss a tailored threat catalog for your industry.',
            'tr' => 'Her büyüklükteki ekip için yönetilen güvenlik farkındalığı egzersizleri yürütüyoruz. Bir demo planlamak, markalı bir kiracı kurmak veya sektörünüze özel bir tehdit kataloğunu tartışmak için bize ulaşın.',
            'de' => 'Wir führen verwaltete Sicherheitsbewusstseinsübungen für Teams jeder Größe durch. Melden Sie sich, um eine Demo zu planen, einen markierten Mandanten einzurichten oder einen maßgeschneiderten Bedrohungskatalog für Ihre Branche zu besprechen.',
        ],
        'landing_dir2_title' => ['en' => 'Check the GitHub &amp; build your own',  'tr' => 'GitHub\'a göz atın ve kendiniz oluşturun', 'de' => 'GitHub ansehen und selbst bauen'],
        'landing_dir2_desc'  => [
            'en' => 'The full source — attack DSL, scheduler, task generator, and multi-tenant infrastructure — is open on GitHub. Fork it, extend the catalog, plug in your own ticketing system, and make it yours.',
            'tr' => 'Tam kaynak kodu — saldırı DSL\'i, zamanlayıcı, görev oluşturucu ve çok kiracılı altyapı — GitHub\'da açık. Fork edin, kataloğu genişletin, kendi bilet sisteminizi takın ve onu sizin yapın.',
            'de' => 'Der vollständige Quellcode – Angriffs-DSL, Scheduler, Aufgaben-Generator und Multi-Tenant-Infrastruktur – ist auf GitHub offen. Forken Sie ihn, erweitern Sie den Katalog, schließen Sie Ihr eigenes Ticketsystem an und machen Sie ihn zu Ihrem.',
        ],
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
