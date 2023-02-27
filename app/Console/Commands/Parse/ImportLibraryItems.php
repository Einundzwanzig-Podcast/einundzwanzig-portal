<?php

namespace App\Console\Commands\Parse;

use App\Models\Lecturer;
use App\Models\Library;
use App\Models\LibraryItem;
use Illuminate\Console\Command;

class ImportLibraryItems extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'import:l';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $items = [
            'https://aprycot.media/blog/weg-zum-bitcoin-standard/'                                                                                 => 'Auf dem Weg zu einem Bitcoin-Standard || Gigi',
            'https://europeanbitcoiners.com/warum-wir-eine-konstante-geldmenge-benoetigen/'                                                        => 'B ~ C: Warum wir eine konstante Geldmenge benötigen || Aleksander Svetski',
            'https://aprycot.media/blog/bitcoin-bringt-das-in-ordnung/'                                                                            => 'Bitcoin bringt das in Ordnung || Parker Lewis',
            'https://europeanbitcoiners.com/orange-new-deal/'                                                                                      => 'Bitcoin: der Orange New Deal || Andrew M. Baily & Bradley Rettler',
            'https://aprycot.media/blog/bitcoin-die-welt-wacht-auf/'                                                                               => 'Bitcoin - die Welt wacht auf || Gigi',
            'https://aprycot.media/blog/bitcoin-ist-einer-fuer-alle/'                                                                              => 'Bitcoin ist \'Einer für Alle\' || Parker Lewis',
            'https://europeanbitcoiners.com/bitcoin-ist-energie-die-durch-die-zeit-reisen-kann/'                                                   => 'Bitcoin ist Energie, die durch die Zeit reisen kann || Michael Dunworth',
            'https://aprycot.media/blog/bitcoin-ist-hoffnung/'                                                                                     => 'Bitcoin ist Hoffnung || Robert Breedlove',
            'https://aprycot.media/blog/bitcoin-ist-schlechter-ist-besser/'                                                                        => 'Bitcoin ist “Schlechter ist Besser” || Gwern Branwen',
            'https://blog.karlklawatsch.com/bitcoin/bitcoin-ist-zeit/'                                                                             => 'Bitcoin ist Zeit || Gigi',
            'https://aprycot.media/blog/bitcoin-ist-antifragil/'                                                                                   => 'Bitcoin ist antifragil || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-die-grosse-entfinanzialisierung/'                                                              => 'Bitcoin ist die große Entfinanzialisierung || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-nicht-durch-nichts-gedeckt/'                                                                   => 'Bitcoin ist durch nichts gedeckt || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-ein-aufschrei/'                                                                                => 'Bitcoin ist ein Aufschrei || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-ein-trojanisches-pferd-der-freiheit/'                                                          => 'Bitcoin ist ein trojanisches Pferd der Freiheit || Alex Gladstein',
            'https://aprycot.media/blog/bitcoin-ist-gesunder-menschenverstand/'                                                                    => 'Bitcoin ist gesunder Menschenverstand || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-kein-schneeballsystem/'                                                                        => 'Bitcoin ist kein Schneeballsystem || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-keine-energieverschwendung/'                                                                   => 'Bitcoin ist keine Energieverschwendung || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-nicht-zu-langsam/'                                                                             => 'Bitcoin ist nicht zu langsam || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-ist-nicht-zu-volatil/'                                                                             => 'Bitcoin ist nicht zu volatil || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-kann-nicht-kopiert-werden/'                                                                        => 'Bitcoin kann nicht kopiert werden || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-kann-nicht-verboten-werden/'                                                                       => 'Bitcoin kann nicht verboten werden || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-macht-anderes-geld-ueberfluessig/'                                                                 => 'Bitcoin macht anderes Geld überflüssig || Parker Lewis',
            'https://aprycot.media/blog/bitcoin-nicht-blockchain/'                                                                                 => 'Bitcoin, nicht Blockchain || Parker Lewis',
            'https://medium.com/aprycotmedia/bitcoins-anpflanzung-71ea533b89c5'                                                                    => 'Bitcoins Anpflanzung || Dan Held',
            'https://aprycot.media/blog/bitcoins-lebensraeume/'                                                                                    => 'Bitcoins Lebensräume || Gigi',
            'https://aprycot.media/blog/bitcoins-einsatz-vor-ort-venezuela/'                                                                       => 'Bitcoins\'s Einsatz vor Ort - Venezuela || Gigi',
            'https://europeanbitcoiners.com/bitcoin-und-psychdelika/'                                                                              => 'Bitcoin und Psychedelika || Fractalencrypt',
            'https://europeanbitcoiners.com/bitcoin-und-die-kardinaltugenden-wie-das-kaninchenloch-tugendhaftes-verhalten-fordert/'                => 'Bitcoin und die Kardinaltugenden: wie der Kaninchenbau tugendhaftes Verhalten fördert || Mitchell Askew',
            'https://aprycot.media/blog/bitcoin-und-die-amerikanische-idee/'                                                                       => 'Bitcoin und die amerikanische Idee || Parker Lewis',
            'https://europeanbitcoiners.com/bitcoin-verkorpert-nikola-teslas-vision-fur-frieden-und-energieuberfluss/'                             => 'Bitcoin verkörpert Nikola Teslas Vision für Frieden und Energieüberfluss || Level39',
            'https://aprycot.media/blog/check-deine-finanziellen-privilegien/'                                                                     => 'Check deine finanziellen Privilegien! || Alex Gladstein',
            'https://www.bitcoin.de/de/bitcoin-whitepaper-deutsch-html'                                                                            => 'Das Bitcoin Whitepaper || Satoshi Nakamoto',
            'https://aprycot.media/blog/das-ei-des-phoenix/'                                                                                       => 'Das Ei des Phönix || Gigi',
            'https://europeanbitcoiners.com/das-manifest-der-bitcoin-hodler-friedfertige-und-monetar-selbstsourverane-individuen/'                 => 'Das Manifest der Bitcoin Hodler: friedfertige und monetär selbstsouveräne Individuen || The Sovereign Hodler 21',
            'https://medium.com/aprycotmedia/das-bullische-argument-f%C3%BCr-bitcoin-9665e9375727'                                                 => 'Das bullische Argument für Bitcoin || Vijay Boyapati',
            'https://medium.com/aprycotmedia/das-monetaere-argument-fuer-bitcoin-62559a4c7b7d'                                                     => 'Das monetäre Argument für Bitcoin || Ben Kaufman',
            'https://aprycot.media/blog/der-aufstieg-des-souveraenen-individuums/'                                                                 => 'Der Aufstieg des souveränen Individuums || Gigi',
            'https://aprycot.media/blog/ewiger-kampf-||-bitcoin/'                                                                                  => 'Der ewige Kampf von Bitcoin || Gigi',
            'https://medium.com/aprycotmedia/die-bitcoin-reise-dab572e5ff72'                                                                       => 'Die Bitcoin-Reise || Gigi',
            'https://aprycot.media/blog/konsequenzen-bitcoin-verbot/'                                                                              => 'Die Konsequenzen eines Bitcoin-Verbots || Gigi',
            'https://aprycot.media/blog/die-suche-nach-digitalem-bargeld/'                                                                         => 'Die Suche nach digitalem Bargeld || Alex Gladstein',
            'https://aprycot.media/blog/die-verantwortung-bitcoin-anzunehmen/'                                                                     => 'Die Verantwortung, Bitcoin anzunehmen || Gigi',
            'https://europeanbitcoiners.com/die-woerter-die-wir-in-bitcoin-verwenden/'                                                             => 'Die Wörter, die wir in Bitcoin verwenden || Gigi',
            'https://aprycot.media/blog/die-wurzel-allen-uebels/'                                                                                  => 'Die Wurzel allen Übels || Fab The Fox',
            'https://aprycot.media/blog/die-zahl-null-und-bitcoin/'                                                                                => 'Die Zahl Null und Bitcoin || Robert Breedlove',
            'https://europeanbitcoiners.com/die-makellose-schoepfung-||-bitcoin/'                                                                  => 'Die makellose Schöpfung von Bitcoin || Pascal Huegli',
            'https://aprycot.media/blog/die-versteckten-kosten-des-petrodollars/'                                                                  => 'Die versteckten Kosten des Petrodollars || Alex Gladstein',
            'https://aprycot.media/blog/freiheit-und-privatsphaere-zwei-seiter-der-gleichen-muenze/'                                               => 'Freiheit und Privatsphäre - Zwei Seiten der gleichen Medaille || Gigi',
            'https://aprycot.media/blog/herren-und-sklaven-des-geldes/'                                                                            => 'Herren und Sklaven des Geldes || Robert Breedlove',
            'https://europeanbitcoiners.com/hyperbitcoinisierung-der-gewinner-bekommt-alles/'                                                      => 'Hyperbitcoinsierung: Der Gewinner bekommt alles || ObiWan Kenobit',
            'https://europeanbitcoiners.com/ist-der-preis-||-bitcoin-volatil-es-ist-alles-relativ/'                                                => 'Ist der Preis von Bitcoin volatil? Es ist alles relativ || Tim Niemeyer',
            'https://aprycot.media/blog/lebenszeichen/'                                                                                            => 'Lebenszeichen || Gigi',
            'https://aprycot.media/blog/liebe-familie-liebe-freunde/'                                                                              => 'Liebe Familie, liebe Freunde || Gigi',
            'https://aprycot.media/?p=92629'                                                                                                       => 'Magisches Internet-Geld || Gigi',
            'https://europeanbitcoiners.com/mises-der-urspruengliche-toxische-maximalist/'                                                         => 'Mises: der ursrpüngliche toxische Maximalist || Michael Goldstein',
            'https://aprycot.media/blog/kolonialismus-und-bitcoin/'                                                                                => 'Monetären Kolonialismus mit Open-Source-Code bekämpfen || Alex Gladstein',
            'https://aprycot.media/blog/privatsphaere-in-bitcoin-bewaehrte-praktiken/'                                                             => 'Privatspähre in Bitcoin: Bewährte Praktiken || Gigi',
            'https://aprycot.media/blog/shelling-out-die-urspruenge-des-geldes/'                                                                   => 'Shelling Out — Die Ursprünge des Geldes || Nick Szabo',
            'https://aprycot.media/blog/spekulative-attacken/'                                                                                     => 'Spekulative Attacken || Pierre Rochard',
            'https://aprycot.media/blog/unveraeusserliche-eigentumsrechte-recht-sprache-geld-und-moral-||-bitcoin/'                                => 'Unveränderliche Eigentumsrechte - Recht, Sprache, Geld und Moral von Bitcoin || Gigi',
            'https://europeanbitcoiners.com/warum-bitcoin-gut-fur-die-umwelt-ist/'                                                                 => 'Warum Bitcoin gut für die Umwelt ist || Leon A. Wankum',
            'https://europeanbitcoiners.com/die-padagogik-von-bitcoin/'                                                                            => 'Die Pädagogik von Bitcoin || Erik Cason',
            'https://europeanbitcoiners.com/bitcoin-first-warum-anleger-bitcoin-getrennt-von-anderen-digitalen-vermogenswerten-betrachten-mussen/' => 'Bitcoin First: Warum Anleger Bitcoin getrennt von anderen digitalen Vermögenswerten betrachten müssen || Fidelity Digital Assets',
            'https://blockinfo.ch/bitcoin-brechen-das-prinzip-von-hartem-geld/'                                                                    => 'Bitcoin brechen — Das Prinzip von hartem Geld || Ben Kaufman',
        ];

        $library = Library::firstOrCreate(['name' => 'Bitcoin Lesestoff by Gigi'], ['created_by' => 1]);

        foreach ($items as $link => $item) {
            $name = str($item)->before(' || ');
            $author = str($item)->after(' || ');

            $contentCreator = Lecturer::firstOrCreate(['name' => $author], [
                'name'       => $author,
                'created_by' => 1,
                'team_id'    => 1,
            ]);

            $libraryItem = LibraryItem::firstOrCreate(['name' => $name], [
                'lecturer_id'   => $contentCreator->id,
                'type'          => 'blog_article',
                'language_code' => 'de',
                'value'         => $link,
                'created_by'    => 1,
            ]);

            try {
                $contents = file_get_contents($link);
                // regex for for og:image
                preg_match('/<meta property="og:image" content="([^"]+)"/', $contents, $matches);
                if (isset($matches[1])) {
                    $image = $matches[1];
                    $libraryItem->addMediaFromUrl($image)
                                ->usingFileName(md5($image->getClientOriginalName()).'.'.$image->getClientOriginalExtension())
                                ->toMediaCollection('main');
                } else {
                    $image = null;
                }
            } catch (\Exception $e) {
                // ignore
            }

            $libraryItem->libraries()
                        ->sync([$library->id]);

            $this->info('Name: '.$name.' Author: '.$author.' Link: '.$link);
        }

        return Command::SUCCESS;
    }
}
