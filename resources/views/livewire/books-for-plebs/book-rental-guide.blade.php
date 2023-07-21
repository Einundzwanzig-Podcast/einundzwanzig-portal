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
        .button-hover:hover { background-color: #FF9900; color: #fff;}
        .link-gray { color: #aaaaaa; }
        .btn, x-button {
            color: #fff;
        }
        .btn:hover, x-button:hover {
            background-color: #FF9900;
        }
    </style>
</head>
<body class="bg-black text-white">

<div class="h-screen w-full">
    <livewire:frontend.header :country="\App\Models\Country::query()->where('code', 'de')->first()"/>

    <div class="px-4 md:px-8 lg:px-24 py-5">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-4xl md:text-5xl text-orange-500 mb-4 md:mb-0">Anleitung zum Bücherverleih</h1>
            <img src="{{ asset('/img/apple_touch_icon.png') }}" alt="Buch Etiketten" class="object-cover h-32 rounded-md shadow-md">
        </div>

        <h2 class="text-2xl md:text-3xl mb-4 text-white">Hallo Pleb,</h2>

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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="flex flex-col items-center">
                <h2 class="text-2xl mb-2 text-orange-500">Bücheretiketten</h2>
                <p class="text-lg text-gray-300 mb-2">(Zum Editieren brauchst du <a href="https://www.adobe.com/de/products/illustrator.html" target="_blank" class="text-orange-500 underline link-gray">Adobe Illustrator)</a></p>
                <img src="{{ asset('/img/etiketten-min.jpeg') }}" alt="Buch Etiketten" class="mb-4 object-cover h-64 rounded-md shadow-md">
                <div class="flex justify-center space-x-2">
                <button class="btn bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    <p class="text-white">
                        Source-Datei Download
                    </p>
                </button>
                <button class="btn bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    <p class="text-white">
                        Beispiel-Datei Download
                    </p>
                </button>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <h2 class="text-2xl mb-2 text-orange-500">Flyer</h2>
                <p class="text-lg text-gray-300 mb-2">(Zum Editieren brauchst du <a href="https://www.adobe.com/de/products/illustrator.html" target="_blank" class="text-orange-500 underline link-gray">Adobe Illustrator)</a></p>

                <img src="{{ asset('/img/flyer-min.jpeg') }}" alt="Flyer" class="mb-4 object-cover h-64 rounded-md shadow-md">
                <div class="flex space-x-2">
                <button class="btn bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    <p class="text-white">
                        Source-Datei Download
                    </p>
                </button>
                <button class="btn bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                    <p class="text-white">
                        Beispiel-Datei Download
                    </p>
                </button>
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
            Für die sichere Lagerung deiner Bücher empfehlen wir einen Meetup-Ort, an dem du regelmäßig bist und die Bücher auch sicher verstaut werden können. Um sicherzustellen, dass 
            der QR-Code nicht entfernt und ausgetauscht wird, empfehlen wir, dass du die Seiten mit Klebeband verbindest oder den QR-Code mit einer Heißklebepistole auf das Buch klebst.
        </p>

        <p class="text-lg text-white mt-8">
    Du willst deine Bücher nicht nur deinem lokalen Meetup zur Verfügung stellen, sondern online an die gesamte Community verschicken, dann komm in die Gruppe:
</p>

<p class="text-lg text-white">
    <a href="https://t.me/BOOKRING4SATS" target="_blank" class="text-orange-500 underline telegram-blue">
        <i class="fab fa-telegram mr-2"></i>@BOOKRING4SATS
    </a>
</p>

<p class="text-lg mt-8 text-white font-bold">
    <i class="fas fa-book mr-2 text-orange-500"></i>Vielen Dank, dass du deine Bücher zur Verfügung stellst und uns dabei hilfst, das Wissen über ₿itcoin zu verbreiten!
</p>

<div class="flex items-center justify-center mt-4">
    <img src="/img/btc-logo-6219386_1280.png" class="h-16" alt="">
    <span class="text-orange-500">Happy Stacking</span>
</div>




    </div>

    <livewire:frontend.footer/>
</div>

</body>
</html>
