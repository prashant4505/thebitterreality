<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\HistoricalFigure;
use App\Models\StaticPage;
use App\Models\Tag;
use App\Models\Timeline;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ─────────────────────────────────────────
        User::updateOrCreate(['email' => 'info@thebitterreality.com'], [
            'name'     => 'Admin',
            'password' => Hash::make('Prashant@123'),
            'is_admin' => true,
        ]);

        // ─── Categories ─────────────────────────────────────────
        $categoriesData = [
            ['slug' => 'history',     'color' => '#f59e0b', 'sort' => 1,  'en' => ['History', 'Civilizations, empires, wars, and the events that shaped humanity.'],        'hi' => ['इतिहास', 'सभ्यताएँ, साम्राज्य, युद्ध और वे घटनाएँ जिन्होंने मानवता को आकार दिया।']],
            ['slug' => 'science',     'color' => '#06b6d4', 'sort' => 2,  'en' => ['Science', 'Discoveries, theories, and breakthroughs that changed our understanding.'],  'hi' => ['विज्ञान', 'खोजें, सिद्धांत और सफलताएँ जिन्होंने हमारी समझ बदल दी।']],
            ['slug' => 'technology',  'color' => '#8b5cf6', 'sort' => 3,  'en' => ['Technology', 'The story of innovation, invention, and the digital revolution.'],         'hi' => ['तकनीक', 'नवाचार, आविष्कार और डिजिटल क्रांति की कहानी।']],
            ['slug' => 'business',    'color' => '#10b981', 'sort' => 4,  'en' => ['Business', 'Corporate rises, epic failures, and lessons from the world of commerce.'],   'hi' => ['व्यापार', 'कॉर्पोरेट उत्थान, महाकाव्य विफलताएँ और वाणिज्य की दुनिया से सबक।']],
            ['slug' => 'philosophy',  'color' => '#ec4899', 'sort' => 5,  'en' => ['Philosophy & Religion', 'Ideas, beliefs, and spiritual traditions that shaped civilization.'], 'hi' => ['दर्शन और धर्म', 'विचार, विश्वास और आध्यात्मिक परंपराएँ।']],
            ['slug' => 'geopolitics', 'color' => '#f97316', 'sort' => 6,  'en' => ['Geopolitics', 'Global power, conflicts, alliances, and the forces shaping nations.'],   'hi' => ['भू-राजनीति', 'वैश्विक शक्ति, संघर्ष, गठबंधन और राष्ट्रों को आकार देने वाली शक्तियाँ।']],
            ['slug' => 'ancient-india','color'=>'#d97706', 'sort' => 7,  'en' => ['Ancient India', 'The Vedic age, great dynasties, philosophy, and cultural achievements.'],  'hi' => ['प्राचीन भारत', 'वैदिक युग, महान राजवंश, दर्शन और सांस्कृतिक उपलब्धियाँ।']],
            ['slug' => 'world-wars',  'color' => '#dc2626', 'sort' => 8,  'en' => ['World Wars', 'The most catastrophic conflicts in human history — causes, events, aftermath.'], 'hi' => ['विश्व युद्ध', 'मानव इतिहास के सबसे विनाशकारी संघर्ष।']],
            ['slug' => 'economics',   'color' => '#059669', 'sort' => 9,  'en' => ['Economics', 'How economies work, major crises, theories, and global trade.'],             'hi' => ['अर्थशास्त्र', 'अर्थव्यवस्थाएँ कैसे काम करती हैं, प्रमुख संकट, सिद्धांत।']],
            ['slug' => 'biographies', 'color' => '#7c3aed', 'sort' => 10, 'en' => ['Biographies', 'Deep dives into the lives of the world\'s greatest minds and leaders.'],   'hi' => ['जीवनियाँ', 'विश्व के महानतम दिमागों और नेताओं के जीवन में गहरी डुबकी।']],
            ['slug' => 'civilizations','color'=>'#b45309','sort'=> 11, 'en' => ['Civilizations', 'Ancient and medieval civilizations — their rise, peak, and fall.'],         'hi' => ['सभ्यताएँ', 'प्राचीन और मध्ययुगीन सभ्यताएँ - उनका उदय, शिखर और पतन।']],
            ['slug' => 'space',       'color' => '#0ea5e9', 'sort' => 12, 'en' => ['Space & Cosmos', 'The universe, space exploration, and humanity\'s journey beyond Earth.'],  'hi' => ['अंतरिक्ष', 'ब्रह्मांड, अंतरिक्ष अन्वेषण और पृथ्वी से परे मानवता की यात्रा।']],
        ];

        $categories = [];
        foreach ($categoriesData as $data) {
            $cat = Category::updateOrCreate(['slug' => $data['slug']], [
                'accent_color' => $data['color'],
                'sort_order'   => $data['sort'],
                'is_active'    => true,
            ]);
            $cat->translations()->updateOrCreate(['locale' => 'en'], ['name' => $data['en'][0], 'description' => $data['en'][1]]);
            $cat->translations()->updateOrCreate(['locale' => 'hi'], ['name' => $data['hi'][0], 'description' => $data['hi'][1]]);
            $categories[$data['slug']] = $cat;
        }

        // ─── Tags ────────────────────────────────────────────────
        $tagsData = [
            'empire'    => ['Empire', 'साम्राज्य'],
            'war'       => ['War', 'युद्ध'],
            'revolution'=> ['Revolution', 'क्रांति'],
            'technology'=> ['Technology', 'तकनीक'],
            'philosophy'=> ['Philosophy', 'दर्शन'],
            'economics' => ['Economics', 'अर्थशास्त्र'],
            'leadership'=> ['Leadership', 'नेतृत्व'],
            'science'   => ['Science', 'विज्ञान'],
            'india'     => ['India', 'भारत'],
            'ancient'   => ['Ancient', 'प्राचीन'],
            'modern'    => ['Modern', 'आधुनिक'],
            'failure'   => ['Corporate Failure', 'कॉर्पोरेट विफलता'],
        ];

        $tags = [];
        foreach ($tagsData as $slug => [$en, $hi]) {
            $tag = Tag::updateOrCreate(['slug' => $slug]);
            $tag->translations()->updateOrCreate(['locale' => 'en'], ['name' => $en]);
            $tag->translations()->updateOrCreate(['locale' => 'hi'], ['name' => $hi]);
            $tags[$slug] = $tag;
        }

        // ─── Historical Figures ──────────────────────────────────
        $figuresData = [
            [
                'slug' => 'chanakya', 'born' => '375 BC', 'died' => '283 BC',
                'era' => 'Ancient India', 'region' => 'Magadha, India', 'category' => 'Philosopher & Statesman',
                'en' => [
                    'name' => 'Chanakya', 'title' => 'The Indian Machiavelli',
                    'short_bio' => 'Ancient Indian philosopher, economist, and royal advisor who masterminded the Maurya Empire.',
                    'quotes' => ['A person should not be too honest. Straight trees are cut first and honest people are screwed first.', 'Education is the best friend. An educated person is respected everywhere. Education beats the beauty and the youth.', 'The world\'s biggest power is the youth and beauty of a woman.'],
                ],
                'hi' => [
                    'name' => 'चाणक्य', 'title' => 'भारतीय मैकियावेली',
                    'short_bio' => 'प्राचीन भारतीय दार्शनिक, अर्थशास्त्री और शाही सलाहकार जिन्होंने मौर्य साम्राज्य की स्थापना में महत्वपूर्ण भूमिका निभाई।',
                ],
            ],
            [
                'slug' => 'julius-caesar', 'born' => '100 BC', 'died' => '44 BC',
                'era' => 'Ancient Rome', 'region' => 'Roman Republic', 'category' => 'Military General & Statesman',
                'en' => [
                    'name' => 'Julius Caesar', 'title' => 'Dictator of Rome',
                    'short_bio' => 'Roman general and statesman who transformed the Roman Republic into the Roman Empire.',
                    'quotes' => ['I came, I saw, I conquered.', 'It is better to create than to learn. Creating is the essence of life.', 'Cowards die many times before their deaths; the valiant never taste death but once.'],
                ],
                'hi' => [
                    'name' => 'जूलियस सीज़र', 'title' => 'रोम के तानाशाह',
                    'short_bio' => 'रोमन सेनापति और राजनेता जिन्होंने रोमन गणराज्य को रोमन साम्राज्य में बदल दिया।',
                ],
            ],
            [
                'slug' => 'ashoka', 'born' => '304 BC', 'died' => '232 BC',
                'era' => 'Ancient India', 'region' => 'Maurya Empire', 'category' => 'Emperor',
                'en' => [
                    'name' => 'Ashoka the Great', 'title' => 'Emperor of the Maurya Dynasty',
                    'short_bio' => 'The third Mauryan emperor who embraced Buddhism after the devastating Kalinga War and became one of the greatest rulers in history.',
                    'quotes' => ['All people are my children.', 'One who is united with the Dharma is truly one who is blessed.'],
                ],
                'hi' => [
                    'name' => 'सम्राट अशोक', 'title' => 'मौर्य वंश के सम्राट',
                    'short_bio' => 'तीसरे मौर्य सम्राट जिन्होंने कलिंग युद्ध के बाद बौद्ध धर्म अपनाया।',
                ],
            ],
            [
                'slug' => 'napoleon-bonaparte', 'born' => '1769', 'died' => '1821',
                'era' => 'Modern', 'region' => 'France / Europe', 'category' => 'Military Commander & Emperor',
                'en' => [
                    'name' => 'Napoleon Bonaparte', 'title' => 'Emperor of the French',
                    'short_bio' => 'French military genius who rose from modest origins to dominate Europe, only to fall due to his own overreach.',
                    'quotes' => ['Impossible is a word found only in the dictionary of fools.', 'Never interrupt your enemy when he is making a mistake.', 'A leader is a dealer in hope.'],
                ],
                'hi' => [
                    'name' => 'नेपोलियन बोनापार्ट', 'title' => 'फ्रांस के सम्राट',
                    'short_bio' => 'फ्रांसीसी सैन्य प्रतिभाशाली जो साधारण पृष्ठभूमि से यूरोप पर हावी होने तक पहुँचे।',
                ],
            ],
            [
                'slug' => 'albert-einstein', 'born' => '1879', 'died' => '1955',
                'era' => 'Modern', 'region' => 'Germany / USA', 'category' => 'Physicist',
                'en' => [
                    'name' => 'Albert Einstein', 'title' => 'Father of Modern Physics',
                    'short_bio' => 'German-born theoretical physicist who developed the theory of relativity and revolutionized our understanding of space, time, and energy.',
                    'quotes' => ['Imagination is more important than knowledge.', 'The measure of intelligence is the ability to change.', 'Life is like riding a bicycle. To keep your balance, you must keep moving.'],
                ],
                'hi' => [
                    'name' => 'अल्बर्ट आइंस्टीन', 'title' => 'आधुनिक भौतिकी के जनक',
                    'short_bio' => 'जर्मन-जन्मे सैद्धांतिक भौतिक विज्ञानी जिन्होंने सापेक्षता का सिद्धांत विकसित किया।',
                ],
            ],
            [
                'slug' => 'krishna', 'born' => '3228 BC (traditional)', 'died' => '3102 BC (traditional)',
                'era' => 'Ancient India / Vedic', 'region' => 'Mathura / Dwarka, India', 'category' => 'Divine Figure & Philosopher',
                'en' => [
                    'name' => 'Lord Krishna', 'title' => 'The Divine Teacher of the Bhagavad Gita',
                    'short_bio' => 'Central figure of the Mahabharata and the Bhagavad Gita. His teachings on duty, devotion, and the nature of reality continue to guide billions.',
                    'quotes' => ['You have the right to perform your actions, but you are not entitled to the fruits of the actions.', 'The soul is never born nor dies at any time.', 'Change is the law of the universe. You can be a millionaire, or a pauper in an instant.'],
                ],
                'hi' => [
                    'name' => 'श्री कृष्ण', 'title' => 'भगवद्गीता के दिव्य गुरु',
                    'short_bio' => 'महाभारत और भगवद्गीता के केंद्रीय पात्र। कर्तव्य, भक्ति और वास्तविकता की प्रकृति पर उनकी शिक्षाएँ अरबों लोगों का मार्गदर्शन करती हैं।',
                ],
            ],
        ];

        $figures = [];
        foreach ($figuresData as $data) {
            $figure = HistoricalFigure::updateOrCreate(['slug' => $data['slug']], [
                'born'         => $data['born'],
                'died'         => $data['died'],
                'era'          => $data['era'],
                'region'       => $data['region'],
                'category'     => $data['category'],
                'is_published' => true,
            ]);
            $figure->translations()->updateOrCreate(['locale' => 'en'], [
                'name'      => $data['en']['name'],
                'title'     => $data['en']['title'],
                'short_bio' => $data['en']['short_bio'],
                'quotes'    => $data['en']['quotes'] ?? [],
            ]);
            $figure->translations()->updateOrCreate(['locale' => 'hi'], [
                'name'      => $data['hi']['name'],
                'title'     => $data['hi']['title'],
                'short_bio' => $data['hi']['short_bio'],
            ]);
            $figures[$data['slug']] = $figure;
        }

        // ─── Topics ──────────────────────────────────────────────
        $admin = User::where('is_admin', true)->first();

        // Topic 1: Roman Empire
        $romanEmpire = Topic::updateOrCreate(['slug' => 'roman-empire'], [
            'category_id'  => $categories['civilizations']->id,
            'user_id'      => $admin->id,
            'era'          => 'Ancient',
            'region'       => 'Europe / Mediterranean',
            'difficulty'   => 'intermediate',
            'reading_time' => 45,
            'is_featured'  => true,
            'is_published' => true,
            'published_at' => now(),
            'view_count'   => 1247,
        ]);
        $romanEmpire->translations()->updateOrCreate(['locale' => 'en'], [
            'title'            => 'The Roman Empire',
            'subtitle'         => 'From a small city-state to the greatest empire in history — and its dramatic fall',
            'excerpt'          => 'For over 500 years, Rome ruled the Western world. Its laws, language, architecture, and culture became the foundation of modern civilization. This is the complete story.',
            'overview'         => '<p>The Roman Empire stands as one of the most remarkable civilizations in human history. At its peak, it stretched from the British Isles to Mesopotamia, governing over 70 million people across three continents.</p><p>This is not just the story of conquest and glory — it is a story of human ambition, political genius, cultural synthesis, economic innovation, and ultimately, the catastrophic collapse of a system that could no longer sustain itself.</p><p>Every chapter of Rome\'s story holds lessons for today: about power, governance, inequality, immigration, climate, and what happens when civilization loses its purpose.</p>',
            'meta_title'       => 'The Roman Empire — Complete History, Rise, Peak & Fall',
            'meta_description' => 'Complete history of the Roman Empire — from its founding in 753 BC to the fall in 476 AD. Learn about Julius Caesar, Augustus, Nero, the army, economy, and why Rome fell.',
        ]);
        $romanEmpire->translations()->updateOrCreate(['locale' => 'hi'], [
            'title'   => 'रोमन साम्राज्य',
            'subtitle'=> 'एक छोटे नगर-राज्य से इतिहास के सबसे महान साम्राज्य तक — और इसका नाटकीय पतन',
            'excerpt' => '500 से अधिक वर्षों तक रोम ने पश्चिमी दुनिया पर शासन किया। यह पूरी कहानी है।',
        ]);
        $romanEmpire->tags()->syncWithoutDetaching([$tags['empire']->id, $tags['ancient']->id, $tags['war']->id]);
        $romanEmpire->figures()->syncWithoutDetaching([$figures['julius-caesar']->id => ['role' => 'Central Figure']]);

        // Chapters for Roman Empire
        $ch1 = $romanEmpire->chapters()->updateOrCreate(['slug' => 'founding-of-rome'], ['sort_order' => 1, 'reading_time' => 8, 'is_published' => true]);
        $ch1->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'The Founding of Rome',
            'summary' => 'From myth to reality — the story of how a small settlement on seven hills became the mightiest city in the ancient world.',
            'content' => '<p>In 753 BC, according to Roman tradition, the city of Rome was founded by Romulus on the Palatine Hill. While archaeology suggests a more gradual settlement, the Romans themselves believed in a divine origin — their city born from the legendary twins Romulus and Remus, suckled by a she-wolf.</p><p>The early Romans were a hardy people, influenced by the Etruscans to the north and the Greeks in southern Italy. They built their city at a strategic crossing of the Tiber River, with seven defensible hills providing natural protection against enemies.</p><h2>The Roman Kingdom (753–509 BC)</h2><p>For the first 244 years, Rome was ruled by kings. Seven kings in total governed the city, each adding to its institutions, laws, and territory. The last king, Tarquinius Superbus (Tarquin the Proud), was so tyrannical that the Roman nobles overthrew him in 509 BC — an event that would shape Roman political thought for centuries.</p><p>The lesson the Romans took from this experience was profound: no single man should ever hold absolute power over the state. This belief became the philosophical foundation of the Roman Republic.</p>',
            'key_lessons' => ['Geography is destiny — Rome\'s location on the Tiber gave it trade advantages that shaped its future.', 'A city\'s founding myths shape its cultural identity for centuries.', 'The rejection of monarchy became Rome\'s defining political value.'],
            'pull_quotes' => [['quote' => 'By fate, Rome was destined to become the seat of the greatest empire the world has ever known.', 'source' => 'Livy, Roman Historian']],
        ]);

        $ch2 = $romanEmpire->chapters()->updateOrCreate(['slug' => 'the-roman-republic'], ['sort_order' => 2, 'reading_time' => 10, 'is_published' => true]);
        $ch2->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'The Roman Republic: Democracy, Senate, and Conquest',
            'summary' => 'How Rome invented the republican system, built a professional army, and conquered the Mediterranean.',
            'content' => '<p>The Roman Republic (509–27 BC) was one of the most innovative political experiments in human history. In a world dominated by monarchies and empires, Rome dared to try something different: a system where power was shared, decisions were made collectively, and no man could become king.</p><p>At its heart were two consuls — elected annually, each able to veto the other. Below them, the Senate of 300 aristocrats (later 600) debated and approved laws. And underpinning everything, the Roman Assembly gave ordinary citizens a voice in their government.</p><h2>The Punic Wars: Rome vs Carthage</h2><p>The three Punic Wars (264–146 BC) between Rome and Carthage were the defining conflict of the ancient Mediterranean. The second war brought Hannibal of Carthage to the very gates of Rome, crossing the Alps with war elephants in one of history\'s most audacious military campaigns.</p><p>Yet Rome survived. And when it finally destroyed Carthage in 146 BC — literally salting the earth so nothing would grow — Rome had become the undisputed master of the Western world.</p>',
            'fact_boxes' => [['title' => 'Key Facts: Roman Republic', 'facts' => ['509 BC: Republic established after expulsion of last king', 'Two consuls elected annually — each could veto the other', '300 senators (later 600) formed the governing body', 'The 12 Tables (450 BC) — Rome\'s first written law code', 'By 264 BC, Rome controlled all of Italy']]],
            'myths_vs_facts' => [['myth' => 'Roman senators were elected by the people', 'fact' => 'Senators were appointed, not elected. They were drawn from the aristocratic class (patricians), and later from wealthy plebeians.']],
        ]);

        $ch3 = $romanEmpire->chapters()->updateOrCreate(['slug' => 'julius-caesar-and-the-fall-of-the-republic'], ['sort_order' => 3, 'reading_time' => 12, 'is_published' => true]);
        $ch3->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'Julius Caesar and the Death of the Republic',
            'summary' => 'The man who crossed the Rubicon, conquered Gaul, and was stabbed to death in the Senate — ending 500 years of republican rule.',
            'content' => '<p>Gaius Julius Caesar was born in 100 BC into a patrician family of modest means. By the time of his assassination in 44 BC, he had conquered Gaul (modern France and Belgium), crossed the English Channel, defeated his rival Pompey, become Dictator of Rome, and fundamentally transformed the Roman state.</p><p>In 49 BC, facing political enemies who demanded he disband his army, Caesar made his fateful decision: he crossed the Rubicon River — the boundary beyond which no Roman general could legally bring his army — with the words "The die is cast." Civil war was now inevitable.</p><h2>The Ides of March</h2><p>Despite his popularity with the common people and the legions, Caesar\'s power terrified the Senate. On March 15, 44 BC, a group of senators led by Brutus and Cassius stabbed him 23 times on the floor of the Senate.</p><p>They believed they were saving the Republic. Instead, they set off a chain of events that would permanently end it. Caesar\'s adopted son Octavian would eventually become Augustus — Rome\'s first emperor.</p>',
            'pull_quotes' => [['quote' => 'I came, I saw, I conquered.', 'source' => 'Julius Caesar'], ['quote' => 'Et tu, Brute?', 'source' => 'Julius Caesar (traditionally attributed)']],
            'key_lessons' => ['When a system cannot reform itself, it becomes vulnerable to strongmen.', 'Killing a dictator doesn\'t restore democracy — it often creates a power vacuum that produces a worse dictator.', 'Caesar\'s murder united his enemies rather than stopping his legacy.'],
        ]);

        // Timeline for Roman Empire
        $timeline = Timeline::updateOrCreate(['topic_id' => $romanEmpire->id, 'slug' => 'roman-empire-timeline'], ['is_published' => true]);
        $timelineEvents = [
            ['753 BC', 'Founding of Rome by Romulus', 'Tradition holds that Romulus founded the city on the Palatine Hill.', 1, 'milestone'],
            ['509 BC', 'Roman Republic Established', 'Last king expelled; consular government begins.', 2, 'turning_point'],
            ['264 BC', 'First Punic War begins', 'Rome vs Carthage — the struggle for the Mediterranean.', 3, 'event'],
            ['49 BC', 'Caesar crosses the Rubicon', 'Triggering civil war that would end the Republic.', 4, 'turning_point'],
            ['44 BC', 'Assassination of Julius Caesar', 'Stabbed 23 times on the Ides of March.', 5, 'turning_point'],
            ['27 BC', 'Augustus becomes first Emperor', 'The Roman Empire officially begins.', 6, 'milestone'],
            ['0 AD', 'Height of Roman Power', 'Rome controls territory from Britain to Mesopotamia.', 7, 'milestone'],
            ['79 AD', 'Eruption of Mount Vesuvius', 'Pompeii buried. Roman civilization captured in ash.', 8, 'event'],
            ['284 AD', 'Crisis of the Third Century ends', 'Empire nearly collapsed but recovered under Diocletian.', 9, 'event'],
            ['395 AD', 'Empire permanently divided', 'Eastern (Byzantine) and Western Roman Empires split.', 10, 'turning_point'],
            ['476 AD', 'Fall of Western Roman Empire', 'Last emperor Romulus Augustulus deposed. End of ancient Rome.', 11, 'milestone'],
        ];
        foreach ($timelineEvents as [$date, $title, $desc, $order, $type]) {
            $entry = $timeline->entries()->updateOrCreate(['sort_order' => $order], ['date_label' => $date, 'type' => $type]);
            $entry->translations()->updateOrCreate(['locale' => 'en'], ['title' => $title, 'description' => $desc]);
        }

        // Topic 2: Why Nokia Failed
        $nokia = Topic::updateOrCreate(['slug' => 'why-nokia-failed'], [
            'category_id'  => $categories['business']->id,
            'user_id'      => $admin->id,
            'era'          => 'Modern',
            'region'       => 'Global / Finland',
            'difficulty'   => 'beginner',
            'reading_time' => 20,
            'is_featured'  => true,
            'is_published' => true,
            'published_at' => now(),
            'view_count'   => 2891,
        ]);
        $nokia->translations()->updateOrCreate(['locale' => 'en'], [
            'title'       => 'Why Nokia Failed',
            'subtitle'    => 'The rise and catastrophic fall of the world\'s most powerful phone company',
            'excerpt'     => 'In 2007, Nokia controlled 40% of the world\'s mobile phone market. By 2013, it had sold its phone business. This is the complete story of how the king of phones lost everything — and the lessons that apply to every business today.',
            'meta_title'  => 'Why Nokia Failed — The Complete Case Study',
            'meta_description' => 'The complete story of Nokia\'s rise and fall. From dominating mobile phones to losing everything in 6 years. What went wrong and what every business can learn.',
        ]);
        $nokia->translations()->updateOrCreate(['locale' => 'hi'], [
            'title'   => 'नोकिया क्यों विफल हुआ',
            'subtitle'=> 'दुनिया की सबसे शक्तिशाली फोन कंपनी का उदय और विनाशकारी पतन',
            'excerpt' => '2007 में नोकिया के पास दुनिया के मोबाइल फोन बाजार का 40% हिस्सा था। 2013 तक उसने अपना फोन व्यवसाय बेच दिया था।',
        ]);
        $nokia->tags()->syncWithoutDetaching([$tags['technology']->id, $tags['failure']->id, $tags['modern']->id]);

        $nch1 = $nokia->chapters()->updateOrCreate(['slug' => 'nokia-rise-to-dominance'], ['sort_order' => 1, 'reading_time' => 7, 'is_published' => true]);
        $nch1->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'The Rise: From Rubber Boots to Ruling the World',
            'summary' => 'Nokia began as a paper mill in 1865. By 1998, it was the world\'s best-selling mobile phone company.',
            'content' => '<p>Nokia\'s story begins in 1865 in Tampere, Finland, where Fredrik Idestam founded a wood pulp mill. Over the next century, the company diversified into rubber boots, cables, and eventually electronics. Nokia made televisions, personal computers, and military equipment before stumbling upon the technology that would make it famous.</p><p>In the early 1990s, Nokia made a critical bet: it decided to focus entirely on mobile telecommunications. This was a brave, counterintuitive decision at a time when mobile phones were large, expensive, and limited to business executives.</p><h2>The 3310 Era</h2><p>The Nokia 3310, launched in 2000, became a cultural phenomenon. It was nearly indestructible, had battery life measured in weeks, and became the bestselling phone in history. At its peak in 2007, Nokia was selling more phones per day than any other company. One in three mobile phones sold globally was a Nokia.</p>',
            'fact_boxes' => [['title' => 'Nokia at its Peak (2007)', 'facts' => ['40% global mobile phone market share', 'Over 63,000 employees worldwide', 'Revenue of $74 billion', 'Produced 400+ million phones per year', 'Brand valued at $35 billion']]],
        ]);

        $nch2 = $nokia->chapters()->updateOrCreate(['slug' => 'the-fall-why-nokia-lost'], ['sort_order' => 2, 'reading_time' => 10, 'is_published' => true]);
        $nch2->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'The Fall: Arrogance, Fear, and the iPhone',
            'summary' => 'How Nokia saw the smartphone revolution coming — and still failed to respond.',
            'content' => '<p>On January 9, 2007, Steve Jobs walked onto a stage in San Francisco and introduced the iPhone. He called it "a revolutionary product that changes everything." Nokia\'s executives watched and were not impressed. They had seen touchscreen prototypes. They had smartphones in development. Their reaction was dismissive: the iPhone had no physical keyboard, poor battery life, and no 3G. It would never work for mass market.</p><p>They were spectacularly wrong.</p><h2>The Real Reasons Nokia Failed</h2><p><strong>1. Cultural fear of bad news.</strong> Internal research revealed that employees were too afraid to tell management the truth about the competition. Middle managers filtered out negative information because Nokia\'s culture punished bad news. The emperor had no clothes — and no one would say so.</p><p><strong>2. Symbian vs iOS/Android.</strong> Nokia\'s operating system, Symbian, was designed for hardware buttons, not touchscreens. It was genuinely difficult to modernize. But Nokia stayed loyal to Symbian too long, paralyzed by the cost of switching.</p><p><strong>3. Organizational paralysis.</strong> Nokia was a matrix organization — every decision required consensus across multiple departments. In the fast-moving smartphone era, this was fatal. Apple made decisions in weeks. Nokia took months.</p>',
            'myths_vs_facts' => [['myth' => 'Nokia failed because it didn\'t see smartphones coming', 'fact' => 'Nokia actually had touchscreen smartphone prototypes in 2003 — 4 years before the iPhone. The failure was execution, culture, and strategy — not vision.']],
            'key_lessons' => ['Market dominance creates complacency — the bigger you are, the harder it is to change.', 'Corporate culture that punishes bad news is ultimately fatal.', 'Speed of decision-making is a competitive advantage in fast-changing industries.', 'Being technically superior does not guarantee market success.'],
            'pull_quotes' => [['quote' => 'We didn\'t do anything wrong, but somehow, we lost.', 'source' => 'Stephen Elop, Nokia\'s last CEO']],
        ]);

        // Topic 3: Maurya Empire
        $maurya = Topic::updateOrCreate(['slug' => 'maurya-empire'], [
            'category_id'  => $categories['ancient-india']->id,
            'user_id'      => $admin->id,
            'era'          => 'Ancient India',
            'region'       => 'Indian Subcontinent',
            'difficulty'   => 'intermediate',
            'reading_time' => 35,
            'is_featured'  => true,
            'is_published' => true,
            'published_at' => now(),
            'view_count'   => 3421,
        ]);
        $maurya->translations()->updateOrCreate(['locale' => 'en'], [
            'title'       => 'The Maurya Empire',
            'subtitle'    => 'India\'s first great empire — built by a genius, expanded by a warrior, transformed by a monk-king',
            'excerpt'     => 'The Maurya Empire was the first to unify most of the Indian subcontinent under a single rule. From Chandragupta\'s revolution to Ashoka\'s transformation, this is the complete story of ancient India\'s greatest empire.',
            'meta_title'  => 'Maurya Empire — Complete History from Chandragupta to Ashoka',
            'meta_description' => 'Complete history of the Maurya Empire (322–185 BC). Learn about Chandragupta Maurya, Chanakya, Ashoka the Great, the Kalinga War, and why the empire fell.',
        ]);
        $maurya->translations()->updateOrCreate(['locale' => 'hi'], [
            'title'   => 'मौर्य साम्राज्य',
            'subtitle'=> 'भारत का पहला महान साम्राज्य — एक प्रतिभाशाली व्यक्ति द्वारा निर्मित, एक योद्धा द्वारा विस्तारित, एक संत-राजा द्वारा रूपांतरित',
            'excerpt' => 'मौर्य साम्राज्य भारतीय उपमहाद्वीप के अधिकांश भाग को एकीकृत करने वाला पहला था। यह पूरी कहानी है।',
        ]);
        $maurya->tags()->syncWithoutDetaching([$tags['empire']->id, $tags['india']->id, $tags['ancient']->id]);
        $maurya->figures()->syncWithoutDetaching([
            $figures['chanakya']->id => ['role' => 'Master Architect'],
            $figures['ashoka']->id   => ['role' => 'Greatest Emperor'],
        ]);

        $mch1 = $maurya->chapters()->updateOrCreate(['slug' => 'chandragupta-and-chanakya'], ['sort_order' => 1, 'reading_time' => 12, 'is_published' => true]);
        $mch1->translations()->updateOrCreate(['locale' => 'en'], [
            'title'   => 'Chandragupta and Chanakya: The Revolution',
            'summary' => 'How a young warrior and an exiled scholar overthrew the Nanda dynasty and built India\'s first empire.',
            'content' => '<p>The story of the Maurya Empire begins with one of history\'s most unlikely partnerships: Chandragupta Maurya, a young man of obscure origin, and Chanakya (also known as Kautilya), a Brahmin scholar who had been publicly humiliated by the Nanda king.</p><p>Around 321 BC, Chanakya — nursing his grudge — began seeking a worthy candidate to overthrow the Nanda dynasty. He found Chandragupta, trained him in statecraft and warfare, and together they built an army from scratch. Their strategy was revolutionary: instead of fighting the powerful Nanda army head-on, they used guerrilla tactics, propaganda, and political subversion to weaken it from within.</p><h2>The Arthashastra</h2><p>Chanakya\'s political treatise, the Arthashastra, was so far ahead of its time that it was compared to Machiavelli\'s The Prince — written 1,800 years later. It covered everything: taxation, foreign policy, espionage, economics, military strategy, and even how to treat the poor.</p>',
            'pull_quotes' => [['quote' => 'Before you start some work, always ask yourself three questions — Why am I doing it? What the results might be? Will I be successful? Only when you think deeply and find satisfactory answers to these questions, go ahead.', 'source' => 'Chanakya']],
            'fact_boxes' => [['title' => 'The Maurya Empire at its Peak', 'facts' => ['Stretched from present-day Afghanistan to Bangladesh', 'Population estimated at 50–60 million people', 'One of the world\'s largest armies: 600,000 infantry, 30,000 cavalry', '9,000 war elephants', 'First Indian empire to challenge Alexander the Great\'s successors']]],
        ]);

        // ─── Search Trends ───────────────────────────────────────
        $trends = ['Roman Empire', 'Nokia failure', 'Chanakya Arthashastra', 'Maurya Empire', 'Julius Caesar assassination', 'Why did Rome fall', 'Ashoka Buddhism', 'Einstein theory of relativity'];
        foreach ($trends as $trend) {
            \App\Models\SearchTrend::updateOrCreate(['query' => $trend], ['count' => rand(100, 5000)]);
        }

        // ─── Static Pages ────────────────────────────────────────
        $pages = [
            ['about-us',      'About The Bitter Reality',       'About Us',          '<p>The Bitter Reality is a premium documentary-style knowledge library. We believe that every topic has a complete story — one that goes beyond headlines and surface-level summaries to explain what really happened, why it happened, and what it means for us today.</p><p>Our mission is to make deep, factual, well-researched knowledge accessible to everyone. Every article on this platform is written with the same care and depth as a documentary film or a chapter from a history book.</p>'],
            ['contact-us',    'Contact The Bitter Reality',      'Contact Us',         '<p>We welcome questions, suggestions, corrections, and collaboration. To reach us, please email: <strong>info@thebitterreality.com</strong></p>'],
            ['privacy-policy','Privacy Policy',                  'Privacy Policy',     '<p><strong>Effective Date:</strong> June 2025</p><p>The Bitter Reality ("we", "us", or "our") is committed to protecting your privacy. This Privacy Policy explains what information we collect, how we use it, and your rights regarding that information when you use our platform at <strong>thebitterreality.com</strong>.</p><h2>1. Information We Collect</h2><p>We collect the following types of information:</p><ul><li><strong>Account Information:</strong> If you create an account, we collect your name and email address. Passwords are stored in an encrypted (hashed) format and are never readable by us.</li><li><strong>Usage Data:</strong> We track which topics and chapters you read, your reading progress, and how you interact with content on the platform. This helps us improve the experience and recommend relevant content.</li><li><strong>Bookmarks and Preferences:</strong> When you save bookmarks or choose a preferred language (English or Hindi), we store those preferences to personalize your experience.</li><li><strong>Comments:</strong> Any comments you post publicly on topics are stored and displayed on the platform. Please do not include personal or sensitive information in comments.</li><li><strong>Search Queries:</strong> We collect anonymized search queries to understand trending topics and improve our content library. Individual searches are not linked to your identity.</li><li><strong>Technical Data:</strong> Like all websites, our servers automatically collect standard technical data such as your IP address, browser type, operating system, referring URL, and pages visited. This information is used solely for security monitoring and analytics.</li></ul><h2>2. How We Use Your Information</h2><p>We use the information we collect to:</p><ul><li>Operate and improve the platform and its content.</li><li>Personalize your reading experience (bookmarks, language preferences, reading history).</li><li>Identify and fix technical issues and security vulnerabilities.</li><li>Analyze content performance to decide which topics to expand or update.</li><li>Communicate with you if you contact us directly, and respond to your inquiries.</li></ul><p>We do <strong>not</strong> use your data for advertising, behavioural profiling, or any commercial purpose beyond operating this platform.</p><h2>3. Cookies</h2><p>We use a minimal set of cookies necessary for the platform to function:</p><ul><li><strong>Session cookies:</strong> Used to keep you logged in while you browse.</li><li><strong>Preference cookies:</strong> Used to remember your chosen language (English or Hindi).</li></ul><p>We do <strong>not</strong> use third-party advertising cookies or tracking pixels. We do not run Google Ads, Facebook Pixel, or any similar tracking technology.</p><h2>4. Data Sharing and Third Parties</h2><p>We do not sell, trade, or rent your personal information to any third party. Your data may be shared only in the following limited circumstances:</p><ul><li><strong>Hosting and Infrastructure:</strong> Our website is hosted on servers managed by trusted infrastructure providers. These providers act as data processors and are contractually bound to protect your data.</li><li><strong>Legal Obligations:</strong> We may disclose information if required to do so by law or in response to a valid legal request from a court or government authority.</li></ul><h2>5. Data Retention</h2><p>We retain your account data and preferences for as long as your account remains active. If you request deletion of your account, we will remove your personal information within 30 days, except where retention is required by law.</p><p>Server logs (IP addresses and technical data) are automatically purged after 90 days.</p><h2>6. Your Rights</h2><p>Depending on your jurisdiction, you may have the right to:</p><ul><li>Access the personal data we hold about you.</li><li>Request correction of inaccurate data.</li><li>Request deletion of your account and associated data.</li><li>Withdraw consent for data processing at any time.</li></ul><p>To exercise any of these rights, please contact us at <strong>info@thebitterreality.com</strong>. We will respond within 30 days.</p><h2>7. Children\'s Privacy</h2><p>The Bitter Reality is an educational platform intended for general audiences. We do not knowingly collect personal information from children under the age of 13. If you believe a child has provided us with personal information, please contact us and we will promptly delete it.</p><h2>8. Security</h2><p>We take reasonable technical and organisational measures to protect your information from unauthorised access, alteration, or disclosure. Passwords are hashed using industry-standard algorithms and are never stored in plain text. However, no method of transmission over the internet is 100% secure, and we cannot guarantee absolute security.</p><h2>9. Changes to This Policy</h2><p>We may update this Privacy Policy from time to time to reflect changes in our practices or legal obligations. When we do, we will update the effective date at the top of this page. We encourage you to review this policy periodically.</p><h2>10. Contact Us</h2><p>If you have any questions, concerns, or requests regarding this Privacy Policy, please reach out to us at: <strong>info@thebitterreality.com</strong></p>'],
            ['disclaimer',    'Disclaimer',                      'Disclaimer',         '<p>The information on this website is for educational purposes only. While we strive for accuracy, historical events are complex and interpretations may vary. Always verify critical information from multiple sources.</p>'],
            ['terms-and-conditions','Terms and Conditions',      'Terms & Conditions', '<p>By accessing and using The Bitter Reality, you agree to be bound by these terms and conditions. Content on this platform is protected by copyright and may not be reproduced without permission.</p>'],
        ];

        foreach ($pages as [$slug, $title, $shortTitle, $content]) {
            $page = StaticPage::updateOrCreate(['slug' => $slug], ['is_published' => true]);
            $page->translations()->updateOrCreate(['locale' => 'en'], ['title' => $title, 'content' => $content]);
        }
    }
}
