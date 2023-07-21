<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anleitung zum Bücherverleih</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .telegram-blue { color: #0088cc; }
        .designer-green { color: #009900; }
    </style>
</head>
<body class="bg-black text-white">

<div class="h-screen w-full">
    <livewire:frontend.header :country="\App\Models\Country::query()->where('code', 'de')->first()"/>

    <div class="px-8 md:px-24 py-5">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-5xl text-orange-500">Anleitung zum Bücherverleih</h1>
            <button class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Sprache wechseln</button>
        </div>

        <h2 class="text-3xl mb-4 text-white">Hallo Pleb,</h2>

        <p class="text-lg mb-8 text-white">
            Vielen Dank, dass du dich dazu entschieden hast, deine <span class="text-orange-500">₿itcoin-Bücher</span> zur Verfügung zu stellen. 
            Mit dieser Anleitung kannst du eine Bezahladresse generieren und hast auch alle Materialien, die du benötigst. 
            Wir haben darauf geachtet, dass es für jedes Meetup geeignet ist. Deshalb stellen wir dir die Quelldateien zur Verfügung, damit du 
            deinen eigenen QR-Code einfügen und das Logo eures Meetups verwenden kannst.<br>

            <p class="text-lg text-white mt-8">
            Du hast keine ₿itcoin Wallet oder kein Programm zum Bearbeiten der Dateien? Kein Problem! Schreib uns einfach und wir helfen dir.

            </p> <br>

            <a href="https://t.me/Awesomo12" target="_blank" class="text-orange-500 underline telegram-blue"><i class="fab fa-telegram mr-2"></i>@Awesomo12</a> <br>
            <a href="https://t.me/LottiTheFuchs" target="_blank" class="text-orange-500 underline telegram-blue"><i class="fab fa-telegram mr-2"></i>@LottiTheFuchs</a>
        </p> <br>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div class="flex flex-col items-start">
                <h2 class="text-2xl mb-2 text-orange-500">Bücheretiketten</h2>
                <p class="text-lg text-gray-300 mb-2">(Zum Editieren brauchst du <a href="https://www.adobe.com/de/products/illustrator.html" target="_blank" class="text-orange-500 underline link-gray">Adobe Illustrator)</a></p>
                <img src="{{ asset('/img/etiketten-min.jpeg') }}" alt="Buch Etiketten" class="mb-4 w-full object-cover h-64 rounded-md shadow-md">
                <div class="flex space-x-2">
                    <x-button download href="{{ asset('assets/book-etiketten-source.jpg') }}" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">
                        Source-Datei Download
                    </x-button>
                    <x-button download href="{{ asset('/img/etiketten-min.jpeg') }}" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">
                        Beispiel-Datei Download
                    </x-button>
                </div>
            </div>

            <div class="flex flex-col items-start">
                <h2 class="text-2xl mb-2 text-orange-500">Flyer</h2>
                <p class="text-lg text-gray-300 mb-2">(Zum Editieren brauchst du <a href="https://www.adobe.com/de/products/illustrator.html" target="_blank" class="text-orange-500 underline link-gray">Adobe Illustrator)</a></p>

                <img src="{{ asset('/img/flyer-min.jpeg') }}" alt="Flyer" class="mb-4 w-full object-cover h-64 rounded-md shadow-md">
                <div class="flex space-x-2">
                    <x-button download href="{{ asset('assets/flyer-source.jpg') }}" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">
                        Source-Datei Download
                    </x-button>
                    <x-button download href="{{ asset('/img/flyer-min.jpeg') }}" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">
                        Beispiel-Datei Download
                    </x-button>
                </div>
            </div>
        </div>

        <p class="text-lg mb-8 text-white">
            Um deinen <span class="text-orange-500">₿itcoin</span> QR-Code zu erstellen, kopiere einfach die Empfangsadresse aus der Wallet deiner Wahl und fügst sie hier ein: <br>
            <a href="https://www.qr-code-generator.com/" target="_blank" class="text-orange-500 underline">www.qr-code-generator.com</a>
        </p>

        <p class="text-lg text-white font-bold mb-8">
            Der QR-Code-Generator akzeptiert sowohl Lightning als auch Onchain-Empfangsadressen. <br>
            <span class="flex items-center text-red-500">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Vorsicht: Lightning-Rechnungen, für einen bestimmten Betrag sind nicht geeignet! Weil diese nach drei Zahlungen ablaufen.
            </span>
        </p>

        <p class="text-lg text-white">
            Für die sichere Lagerung deiner Bücher empfehlen wir einen Meetup-Ort, an dem du regelmäßig bist und die Bücher auch sicher verstaut werden können. Um sicherzustellen, dass du nicht betrogen wirst, haben wir auf dem Etikett ein Feld namens "Leih-Bedingung" eingerichtet. Hier kannst du einen Pfand bzw. Gegenwert sowie eine wöchentliche oder monatliche Leihgebühr festlegen.
        </p> 

        <p class="text-lg text-white mt-8">
            Du willst deine Bücher nicht nur deinem lokalen Meetup zur Verfügung stellen, sondern online an die gesamte Community verschicken, dann komm in die Gruppe:
        </p> 

        <p class="text-lg text-white">
            <a href="https://t.me/BOOKRING4SATS" target="_blank" class="text-orange-500 underline telegram-blue"><i class="fab fa-telegram mr-2"></i>@BOOKRING4SATS</a>
        </p>
    </div>

    <livewire:frontend.footer/>
</div>

</body>
</html>