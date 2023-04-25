<?php

namespace App;

use App\Models\BitcoinEvent;
use App\Models\Course;
use App\Models\LibraryItem;
use App\Models\MeetupEvent;
use App\Models\OrangePill;
use App\Models\User;
use Illuminate\Support\Facades\Http;

trait CodeIsSpeech
{
    public function bookCasesHighScoreTable()
    {
        $firstUser = User::query()
                         ->withCount('orangePills')
                         ->orderByDesc('orange_pills_count')
                         ->first();
        return sprintf("
        Derzeit liegt %s ganz vorne in der Highscore-Tabelle.
        Er oder sie hat sage und schreibe %s Bücher in Schränke gestellt.
        ",
            $firstUser->name,
            $firstUser->orange_pills_count
        );
    }

    public function bookCasesCommentBookcase()
    {
        return sprintf("
        %s ist ein cooler Bittcoiner und hat ein Buch in einen Schrank gestellt.
        Finde den Schrank mit Hilfe der Karte und trage auch deine Buch-Eingabe hier ein.
        Gehe auf die Highscore-Tabelle um zu sehen, wer die meisten Bücher in Schränke gestellt hat.
        ",
            $this->bookCase->orangePills->first()->user->name
        );
    }

    public function bookCasesWorld()
    {
        return sprintf("
        Hier siehst du die Anzahl der Bücherschranke-Einträge und auch die Anzahl der Bittcoiner, die ein Buch in ein Regal gestellt haben.
        Auf der Weltkarte kannst du sehen, welche Regale noch kein Buch haben.
        Diese Regale sind gräulich gefärbt.
        Regale in oransch haben bereits ein Buch.
        Es kann jedoch sein, dass das Buch schon eine lange Reise hinter sich hat und ganz wo anders auf der Welt zu finden ist.
        Wenn du auf einen Marker klickst gelangst du zu den Details des Regals.
        Derzeit haben %s Bittcoiner %s Bücher in Regale eingestellt.
        ",
            User::query()
                ->whereHas('orangePills')
                ->count(),
            OrangePill::query()
                      ->count()
        );
    }

    public function bitcoinEventTableBitcoinEvent()
    {
        return sprintf("
        Alle Termine für Bitcoin-Ivents werden hier angezeigt.
        Finde einen Termin, der dir passt und klicke auf den 'Link', um zu den Details zu gelangen.
        Die Termine haben eine Flagge, die das Land anzeigt, in dem das Event stattfindet.
        ",
        );
    }

    public function libraryTableLibraryItems()
    {
        return sprintf("
            Du kannst in unserer Bibliothek nach Themen suchen, die dich interessieren.
            Tippe einen Suchbegriff ein oder wähle einen Schlagwort aus, um die Ergebnisse zu filtern.
            Wenn du selbst eigene interessante Artikel oder Bibliotheks-Einträge eingeben möchtest, musst du eingeloggt sein.
            Klicke auf 'Inhalte eintragen' und fülle das Formular aus.
            So wird die Bibliothek immer besser und du kannst die Inhalte mit anderen teilen.
        ",
        );
    }

    public function schoolTableEvent()
    {
        $filterId = null;
        if (isset($this->getAppliedFilters()['course_id'])) {
            $filterId = $this->getAppliedFilters()['course_id'];
        } else {

            return;
        }
        $course = Course::query()
                        ->with(['lecturer'])
                        ->find($filterId);

        return sprintf("
        Du hast den Kurs '%s' von %s gefiltert.
        Finde hier einen Termin, der dir passt und klicke auf 'Registrieren', um zu den Details zu gelangen.
        Auf der Karte findest du weitere Kurse, die in deiner Nähe stattfinden.
        Klicke einen Marker um die Filterung nach Terminen zu ändern.
        ",
            $course->name,
            $course->lecturer->name
        );
    }

    public function schoolTableCourse()
    {
        return sprintf("
            Du bist auf der Übersichts-Seite der Kurse.
            Finde hier ein Themen-Gebiet, das dich interessiert und klicke auf den Link, um zu den Terminen zu gelangen.
        ",
        );
    }

    public function meetupLanding()
    {
        return sprintf("
            Du bist auf der Mietap Seite von %s.
            Suche dir einen Termin aus und freue dich auf ein Treffen mit Gleichgesinnten oder einfach nur auf einen gemütlichen Abend.
            Wenn ein Mietap Termin fehlt, dann logge dich im System ein und wähle deine Mietaps unter 'Meine Meetups' aus, um einen neuen Termin anzulegen.
        ",
            $this->meetup->name,
        );
    }

    public function meetupWorld()
    {
        return sprintf("
        Du bist auf der Mietap Weltkarte von Einundzwanzig.
        Suche dir ein Land aus und klicke auf den Marker, um zu einem Mietap zu gelangen.
        Wenn ein Mietap fehlt, dann logge dich im System ein und lege ein neues Mietap an.
        ");
    }

    public function profileLnbits()
    {
        return sprintf("
        Setze hier die Einstellungen für deine LN Bitts Wollet. Bitte verwende deine eigene Instanz von LN Bitts, die auf deiner eigenen Bitcoin Nod installiert ist.
        ");
    }

    public function articleView(): string
    {
        return str(strip_tags($this->libraryItem->value))
            ->stripTags()
            ->words(255, '')
            ->toString();
    }

    public function articleOverview()
    {
        $tip = Http::get('https://mempool.space/api/blocks/tip/height');
        $fees = Http::get('https://mempool.space/api/v1/fees/recommended')
                    ->json();

        $createText = "Um einen Artikel zu schreiben, klicke auf den 'Artikel einreichen' Link oder um einen bezahlten Artikel zu schreiben, klicke auf 'Reiche einen bezahlten News-Artikel ein'.";
        if (auth()->check() && !auth()->user()->lnbits['read_key']) {
            $createText = "Um einen Artikel zu schreiben, klicke auf den 'Artikel einreichen' Link oder um einen bezahlten Artikel zu schreiben, richte zuerst deine Verbindung zu LN Bitts ein. Klicke dazu auf 'Setze LN Bitts für bezahlte Artikel ein'";
        }

        return sprintf("
        Du bist auf der News Seite von Einundzwanzig.
        Wir haben für dich derzeit insgesamt %s Artikel geschrieben.
        Die derzeitige Bitcoin Blockzeit ist %s.
        Die schnellsten Transaktionen verschickst du derzeit mit einer Gebühr von %s Satoschi pro Byte.
        %s
        ",
            LibraryItem::query()
                       ->where('news', true)
                       ->count(),
            $tip->json(),
            $fees['fastestFee'],
            $createText
        );
    }

    public function authLn()
    {
        return sprintf("
        Du bist auf der Login Seite von Einundzwanzig.
        Du kannst dich hier mit deiner Lightning Applikation einloggen.
        Benutze diesen QR-Code oder kopiere ihn in deine Lightning-App. Oder klicke auf den QR-Code, um dich mit der Applikation einzuloggen.
        Deine Lightning Applikation muss L N URL auth unterstützen.
        Du siehst ganz unten in der Box eine Liste von Lightning Applikationen, die L N URL auth unterstützen.
        ");
    }

    public function welcome()
    {
        return sprintf("
        Hallo und herzlich willkommen auf dem Portal von Einundzwanzig.
        Klicke einfach auf Login, um Events einzutragen oder News Artikel zu schreiben.
        Du brauchst eine Lightning Applikation dafür.
        Viel Spaß!

        Derzeit sind %s Events eingetragen.
        Markus Turm hat %s Artikel geschrieben und %s Artikel dezentralisiert.
        Wir haben %s Bitcoin Bücher in Bücherregale verteilt.
        Du kannst die einen Termin von insgesamt %s Treffen aussuchen.
        ",
            BitcoinEvent::count(),
            LibraryItem::where('created_by', 2)
                       ->where('news', true)
                       ->count(),
            LibraryItem::where('created_by', '<>', 2)
                       ->where('news', true)
                       ->count(),
            OrangePill::count(),
            MeetupEvent::where('start', '>=', now())
                       ->count()
        );
    }
}
