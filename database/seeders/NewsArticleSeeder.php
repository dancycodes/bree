<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsArticleSeeder extends Seeder
{
    public function run(): void
    {
        /** @var array<string, \App\Models\NewsCategory> $categories */
        $categories = NewsCategory::whereIn('slug', [
            'programmes',
            'sante',
            'environnement',
            'education',
            'partenariats',
            'rapports',
        ])->get()->keyBy('slug')->all();

        $articles = [
            [
                'slug' => 'conference-sante-mentale-2026',
                'title_fr' => 'Conférence sur la Santé Mentale des Jeunes — 4 Mars 2026',
                'title_en' => 'Youth Mental Health Conference — March 4, 2026',
                'excerpt_fr' => "La Fondation BREE organise une conférence internationale sur la santé mentale des jeunes à l'Hôpital Jamot de Yaoundé, réunissant experts, professionnels de santé et jeunes bénéficiaires.",
                'excerpt_en' => 'Fondation BREE is hosting an international conference on youth mental health at Hôpital Jamot in Yaoundé, bringing together experts, health professionals and young beneficiaries.',
                'content_fr' => "Dans le cadre de l'initiative BREE PROTÈGE, la Fondation BREE organise le 4 mars 2026 une conférence internationale dédiée à la santé mentale des jeunes. L'événement se tiendra à l'Hôpital Jamot de Yaoundé, établissement partenaire de référence pour nos programmes de soutien psychologique.\n\nPlus de 300 participants sont attendus : psychiatres, psychologues, travailleurs sociaux, représentants institutionnels et jeunes ayant bénéficié de nos programmes. La conférence s'articulera autour de trois axes principaux : l'état des lieux de la santé mentale juvénile au Cameroun, les bonnes pratiques d'accompagnement psychologique, et les voies de financement durable pour ces programmes.\n\nCet événement marque une étape importante dans notre engagement à briser le tabou autour de la santé mentale et à garantir un accès équitable aux soins psychologiques pour tous les jeunes camerounais.",
                'content_en' => "As part of the BREE PROTECTS initiative, Fondation BREE is hosting an international conference dedicated to youth mental health on 4 March 2026. The event will take place at Hôpital Jamot in Yaoundé, our reference partner establishment for psychological support programmes.\n\nMore than 300 participants are expected: psychiatrists, psychologists, social workers, institutional representatives and young people who have benefited from our programmes. The conference will be structured around three main themes: the state of youth mental health in Cameroon, best practices in psychological support, and sustainable funding pathways for these programmes.\n\nThis event marks an important milestone in our commitment to breaking the taboo around mental health and ensuring equitable access to psychological care for all young Cameroonians.",
                'category_fr' => 'Santé',
                'category_en' => 'Health',
                'category_slug' => 'sante',
                'news_category_id' => $categories['sante']->id ?? null,
                'thumbnail_path' => 'images/news/conference-sante-mentale.jpg',
                'status' => 'published',
                'published_at' => '2026-02-15 09:00:00',
            ],
            [
                'slug' => 'bree-protege-500-enfants-2025',
                'title_fr' => 'BREE PROTÈGE : 500 enfants soutenus en 2025',
                'title_en' => 'BREE PROTECTS: 500 Children Supported in 2025',
                'excerpt_fr' => "L'initiative BREE PROTÈGE dresse un bilan positif pour l'année 2025 : 500 enfants ont bénéficié d'un accès aux soins de santé et d'un accompagnement psychologique.",
                'excerpt_en' => 'The BREE PROTECTS initiative reports a positive outcome for 2025: 500 children benefited from access to healthcare and psychological support.',
                'content_fr' => "L'initiative BREE PROTÈGE clôt l'année 2025 sur un bilan remarquable : 500 enfants vulnérables ont été soutenus à travers trois piliers d'intervention complémentaires.\n\nPremièrement, l'accès aux soins de santé primaire. Grâce à nos partenariats avec des établissements de santé à Yaoundé, Douala et Bafoussam, 500 enfants issus de familles défavorisées ont bénéficié de consultations médicales gratuites, de vaccinations et de traitements préventifs.\n\nDeuxièmement, le soutien psychologique. Notre équipe de sept psychologues cliniciens a assuré un suivi individuel pour 120 enfants présentant des traumatismes liés à des situations de violence familiale ou de précarité extrême.\n\nTroisièmement, la protection juridique. En partenariat avec le Barreau du Cameroun, nous avons accompagné 45 familles dans des procédures de protection de l'enfance, garantissant les droits fondamentaux de leurs enfants.\n\nCes résultats sont le fruit d'une mobilisation collective : donateurs, bénévoles, partenaires institutionnels et communautés locales. Ensemble, nous construisons un Cameroun où chaque enfant grandit en sécurité.",
                'content_en' => "The BREE PROTECTS initiative closes 2025 with a remarkable record: 500 vulnerable children were supported through three complementary pillars of intervention.\n\nFirst, access to primary healthcare. Through our partnerships with healthcare facilities in Yaoundé, Douala and Bafoussam, 500 children from disadvantaged families benefited from free medical consultations, vaccinations and preventive treatments.\n\nSecond, psychological support. Our team of seven clinical psychologists provided individual follow-up for 120 children experiencing trauma linked to situations of family violence or extreme poverty.\n\nThird, legal protection. In partnership with the Cameroon Bar Association, we assisted 45 families in child protection proceedings, guaranteeing the fundamental rights of their children.\n\nThese results are the fruit of collective mobilisation: donors, volunteers, institutional partners and local communities. Together, we are building a Cameroon where every child grows up in safety.",
                'category_fr' => 'Programmes',
                'category_en' => 'Programs',
                'category_slug' => 'programmes',
                'news_category_id' => $categories['programmes']->id ?? null,
                'thumbnail_path' => 'images/news/bree-protege-500-enfants.jpg',
                'status' => 'published',
                'published_at' => '2025-12-20 10:00:00',
            ],
            [
                'slug' => 'nettoyage-communautaire-yaounde',
                'title_fr' => 'Journée de nettoyage communautaire à Yaoundé',
                'title_en' => 'Community Cleanup Day in Yaoundé',
                'excerpt_fr' => 'BREE RESPIRE a mobilisé 200 volontaires pour une grande journée de nettoyage à Yaoundé, collectant 3 tonnes de déchets dans les quartiers défavorisés.',
                'excerpt_en' => 'BREE BREATHES mobilised 200 volunteers for a major cleanup day in Yaoundé, collecting 3 tonnes of waste in disadvantaged neighbourhoods.',
                'content_fr' => "Le samedi 1er novembre 2025, l'initiative BREE RESPIRE a organisé une journée de nettoyage communautaire d'envergure dans quatre quartiers de Yaoundé : Briqueterie, Melen, Nkol-Eton et Mvog-Ada.\n\nPas moins de 200 volontaires — étudiants, professionnels, riverains et membres de la Fondation BREE — ont participé à cet élan collectif pour un cadre de vie plus sain. En l'espace de six heures, l'équipe a collecté 3 tonnes de déchets solides, dont une large proportion de plastiques à usage unique.\n\nAu-delà du nettoyage, des sessions de sensibilisation au tri sélectif et au compostage ont été animées par nos équipes environnementales dans chaque quartier. Des kits de jardinage urbain ont également été distribués à 50 ménages volontaires pour encourager la végétalisation des espaces communs.\n\nCette journée s'inscrit dans la stratégie annuelle de BREE RESPIRE, qui ambitionne de mobiliser 1 000 volontaires pour des actions environnementales dans six villes camerounaises d'ici fin 2026.",
                'content_en' => "On Saturday 1 November 2025, the BREE BREATHES initiative organised a large-scale community cleanup day in four districts of Yaoundé: Briqueterie, Melen, Nkol-Eton and Mvog-Ada.\n\nNo fewer than 200 volunteers — students, professionals, residents and Fondation BREE members — participated in this collective drive for a healthier living environment. In the space of six hours, the team collected 3 tonnes of solid waste, a large proportion of which consisted of single-use plastics.\n\nBeyond the cleanup, awareness sessions on waste sorting and composting were facilitated by our environmental teams in each district. Urban gardening kits were also distributed to 50 volunteer households to encourage the greening of shared spaces.\n\nThis day is part of BREE BREATHES' annual strategy, which aims to mobilise 1,000 volunteers for environmental actions in six Cameroonian cities by the end of 2026.",
                'category_fr' => 'Environnement',
                'category_en' => 'Environment',
                'category_slug' => 'environnement',
                'news_category_id' => $categories['environnement']->id ?? null,
                'thumbnail_path' => 'images/news/nettoyage-communautaire-yaounde.jpg',
                'status' => 'published',
                'published_at' => '2025-11-05 08:00:00',
            ],
            [
                'slug' => 'bourses-scolaires-45-filles',
                'title_fr' => 'Bourses scolaires : 45 filles scolarisées grâce à BREE ÉLÈVE',
                'title_en' => 'Scholarships: 45 Girls in School Thanks to BREE ELEVATES',
                'excerpt_fr' => "Le programme BREE ÉLÈVE a octroyé des bourses scolaires à 45 jeunes filles de régions rurales, leur ouvrant les portes d'un avenir meilleur à travers l'éducation.",
                'excerpt_en' => 'The BREE ELEVATES programme awarded scholarships to 45 girls from rural regions, opening the doors to a better future through education.',
                'content_fr' => "L'éducation des filles est au cœur de la mission de la Fondation BREE. En octobre 2025, le programme BREE ÉLÈVE a attribué 45 bourses scolaires complètes à des jeunes filles issues de familles vulnérables, réparties dans sept régions du Cameroun.\n\nChaque bourse couvre l'intégralité des frais de scolarité, l'achat de fournitures scolaires, et pour les bénéficiaires les plus éloignées, une aide au logement en internat. Parmi les bénéficiaires, 18 poursuivent leurs études secondaires, 12 sont inscrites dans des lycées techniques, et 15 accèdent pour la première fois à l'enseignement supérieur.\n\nLes témoignages de ces jeunes filles illustrent l'impact concret du programme. Fatoumata, 16 ans, originaire de la région de l'Adamaoua, confie : « Grâce à BREE ÉLÈVE, j'ai pu intégrer le lycée scientifique de Ngaoundéré. Mon rêve est de devenir médecin. » Marie-Claire, 20 ans, du Littoral, est la première de sa famille à accéder à l'université.\n\nLa Fondation BREE s'engage à porter ce programme à 200 bourses annuelles d'ici 2027, en multipliant les partenariats avec des entreprises locales et des bailleurs de fonds internationaux.",
                'content_en' => "The education of girls is at the heart of Fondation BREE's mission. In October 2025, the BREE ELEVATES programme awarded 45 full scholarships to girls from vulnerable families, spread across seven regions of Cameroon.\n\nEach scholarship covers all school fees, the purchase of school supplies, and for those beneficiaries who live furthest away, boarding accommodation assistance. Among the recipients, 18 are continuing their secondary education, 12 are enrolled in technical high schools, and 15 are accessing higher education for the first time.\n\nThe testimonials of these young women illustrate the concrete impact of the programme. Fatoumata, aged 16, from the Adamaoua region, says: 'Thanks to BREE ELEVATES, I was able to enrol in the science lycée in Ngaoundéré. My dream is to become a doctor.' Marie-Claire, 20, from the Littoral region, is the first in her family to access university.\n\nFondation BREE is committed to expanding this programme to 200 annual scholarships by 2027, by multiplying partnerships with local businesses and international donors.",
                'category_fr' => 'Éducation',
                'category_en' => 'Education',
                'category_slug' => 'education',
                'news_category_id' => $categories['education']->id ?? null,
                'thumbnail_path' => 'images/news/bourses-scolaires-45-filles.jpg',
                'status' => 'published',
                'published_at' => '2025-10-12 09:00:00',
            ],
            [
                'slug' => 'premiere-dame-soutient-fondation-bree',
                'title_fr' => 'La Première Dame soutient la Fondation BREE',
                'title_en' => 'The First Lady Supports Fondation BREE',
                'excerpt_fr' => 'Son Excellence Madame Chantal BIYA, Première Dame de la République du Cameroun, a accordé son haut patronage à la Fondation BREE, renforçant sa crédibilité et son rayonnement.',
                'excerpt_en' => 'Her Excellency Madame Chantal BIYA, First Lady of the Republic of Cameroon, granted her high patronage to Fondation BREE, strengthening its credibility and reach.',
                'content_fr' => "C'est avec une immense fierté que la Fondation BREE annonce l'obtention du haut patronage de Son Excellence Madame Chantal BIYA, Première Dame de la République du Cameroun et fondatrice de la Fondation Chantal BIYA.\n\nCet acte de soutien, formalisé en septembre 2025, témoigne de la convergence des valeurs entre les deux institutions : la défense des droits des femmes et des enfants, la promotion de la santé publique, et l'engagement pour un développement humain durable au Cameroun.\n\nDans son message de soutien, Son Excellence a déclaré : « La Fondation BREE incarne les valeurs de solidarité et de dignité humaine qui nous sont chères. L'engagement de sa fondatrice, Anastasie Brenda BIYA, pour les femmes et les enfants les plus vulnérables de notre société mérite d'être soutenu et encouragé. Je m'associe pleinement à cette noble cause. »\n\nLe haut patronage de la Première Dame ouvre de nouvelles perspectives pour la Fondation BREE : accès à des réseaux institutionnels élargis, visibilité accrue auprès des bailleurs de fonds internationaux, et renforcement de la légitimité de nos actions sur le terrain.",
                'content_en' => "It is with immense pride that Fondation BREE announces the granting of high patronage by Her Excellency Madame Chantal BIYA, First Lady of the Republic of Cameroon and founder of the Fondation Chantal BIYA.\n\nThis act of support, formalised in September 2025, reflects the convergence of values between the two institutions: the defence of the rights of women and children, the promotion of public health, and the commitment to sustainable human development in Cameroon.\n\nIn her message of support, Her Excellency stated: 'Fondation BREE embodies the values of solidarity and human dignity that are dear to us. The commitment of its founder, Anastasie Brenda BIYA, to the most vulnerable women and children in our society deserves to be supported and encouraged. I fully associate myself with this noble cause.'\n\nThe First Lady's high patronage opens new perspectives for Fondation BREE: access to expanded institutional networks, increased visibility with international donors, and strengthened legitimacy of our actions in the field.",
                'category_fr' => 'Partenariats',
                'category_en' => 'Partnerships',
                'category_slug' => 'partenariats',
                'news_category_id' => $categories['partenariats']->id ?? null,
                'thumbnail_path' => 'images/news/premiere-dame-soutient-bree.jpg',
                'status' => 'published',
                'published_at' => '2025-09-01 10:00:00',
            ],
            [
                'slug' => 'rapport-annuel-2025',
                'title_fr' => "Rapport annuel 2025 : une année d'impact",
                'title_en' => 'Annual Report 2025: A Year of Impact',
                'excerpt_fr' => "La Fondation BREE publie son rapport annuel 2025 : une synthèse de l'impact de nos trois programmes phares, des chiffres clés et un engagement renouvelé pour la transparence.",
                'excerpt_en' => 'Fondation BREE publishes its 2025 annual report: a synthesis of the impact of our three flagship programmes, key figures and a renewed commitment to transparency.',
                'content_fr' => "La Fondation BREE présente avec fierté son rapport annuel 2025, témoignage d'une année placée sous le signe de l'engagement et de l'impact mesurable.\n\n**BREE PROTÈGE — Protection des femmes et des enfants**\n500 enfants soutenus, 120 accompagnements psychologiques individuels, 45 procédures de protection juridique conduites. Notre programme phare de protection a renforcé son ancrage dans les zones prioritaires de Yaoundé, Douala et Bafoussam.\n\n**BREE RESPIRE — Environnement et cadre de vie**\n4 journées de nettoyage communautaire organisées, 200 volontaires mobilisés, 3 tonnes de déchets collectés. Le programme BREE RESPIRE a également lancé deux jardins communautaires urbains dans les quartiers de Melen et Briqueterie.\n\n**BREE ÉLÈVE — Éducation et autonomisation**\n45 bourses scolaires attribuées, 7 régions couvertes, 100 % de taux de maintien en cours d'année. Le programme a également mis en place 3 ateliers de formation professionnelle pour les mères de bénéficiaires.\n\n**Transparence financière**\n78 % des ressources collectées sont directement affectées aux programmes. Les comptes 2025 ont été certifiés par un cabinet d'audit indépendant. La Fondation BREE remercie l'ensemble de ses donateurs, partenaires et bénévoles qui ont rendu ces résultats possibles.",
                'content_en' => "Fondation BREE presents with pride its 2025 annual report, a testament to a year marked by commitment and measurable impact.\n\n**BREE PROTECTS — Protection of Women and Children**\n500 children supported, 120 individual psychological follow-ups, 45 legal protection proceedings conducted. Our flagship protection programme strengthened its presence in the priority areas of Yaoundé, Douala and Bafoussam.\n\n**BREE BREATHES — Environment and Living Conditions**\n4 community cleanup days organised, 200 volunteers mobilised, 3 tonnes of waste collected. The BREE BREATHES programme also launched two urban community gardens in the Melen and Briqueterie districts.\n\n**BREE ELEVATES — Education and Empowerment**\n45 scholarships awarded, 7 regions covered, 100% in-year retention rate. The programme also established 3 vocational training workshops for beneficiaries' mothers.\n\n**Financial Transparency**\n78% of resources collected are directly allocated to programmes. The 2025 accounts have been certified by an independent audit firm. Fondation BREE thanks all its donors, partners and volunteers who made these results possible.",
                'category_fr' => 'Rapports',
                'category_en' => 'Reports',
                'category_slug' => 'rapports',
                'news_category_id' => $categories['rapports']->id ?? null,
                'thumbnail_path' => 'images/news/rapport-annuel-2025.jpg',
                'status' => 'published',
                'published_at' => '2026-01-30 11:00:00',
            ],
        ];

        foreach ($articles as $article) {
            NewsArticle::updateOrCreate(
                ['slug' => $article['slug']],
                $article,
            );
        }
    }
}
