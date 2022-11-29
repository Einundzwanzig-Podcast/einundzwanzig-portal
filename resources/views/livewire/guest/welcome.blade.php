<div>
    <section class="w-full bg-black overflow-hidden">
        <div class="max-w-7xl mx-auto px-10">
            <div class="flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="#_"
                       class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">
                        {{--<a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Home</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Features</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Pricing</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Blog</a>--}}
                    </nav>
                </div>
                <div class="inline-flex items-center ml-5 text-lg space-x-6 lg:justify-end">
                    <a href="#"
                       class="text-base font-medium leading-6 text-gray-400 hover:text-gray-300 whitespace-no-wrap transition duration-150 ease-in-out">
                        Login </a>
                    <a href="#"
                       class="inline-flex items-center justify-center px-4 py-2 font-medium leading-6 text-gray-200 hover:text-white whitespace-no-wrap bg-gray-800 border border-transparent rounded shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                        Registrieren </a>
                </div>
            </div>
            <div class="flex lg:flex-row flex-col pt-20 md:pt-40 lg:pt-20">
                <div
                    class="w-full lg:w-1/2 flex lg:px-0 px-5 flex-col md:items-center lg:items-start justify-center -mt-12">
                    <h1 class="text-white text-3xl sm:text-5xl lg:max-w-none max-w-4xl lg:text-left text-left md:text-center xl:text-7xl font-black">
                        EINUNDZWANZIG <br class="lg:block sm:hidden">Bitcoin <span
                            class="bg-clip-text text-transparent bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-700 mt-1 lg:block">School</span>
                    </h1>
                    <p class="text-gray-500 sm:text-lg md:text-xl xl:text-2xl lg:max-w-none max-w-2xl md:text-center lg:text-left lg:pr-32 mt-6">
                        Finde Bitcoin Kurse in deiner City</p>
                    <a href="#_"
                       class="bg-white px-12 lg:px-16 py-4 text-center lg:py-5 font-bold rounded text-lg md:text-xl lg:text-2xl mt-8 inline-block w-auto">
                        Kurs finden </a>
                    <p class="text-gray-400 font-normal mt-4">TEXT</p>
                </div>
                <div class="w-full lg:w-1/2 relative lg:mt-0 mt-20 flex items-center justify-center">
                    <img src="https://cdn.devdojo.com/images/march2022/mesh-gradient1.png"
                         class="absolute lg:max-w-none max-w-3xl mx-auto mt-32 w-full h-full inset-0">
                    <img src="{{ asset('img/btc-logo-6219386_1280.png') }}"
                         class="w-full md:w-auto w-72 max-w-md max-w-sm ml-4 md:ml-20 lg:ml-0 xl:max-w-lg relative">
                </div>
            </div>
        </div>
    </section>

    <section class="w-full mt-12">
        <div class="max-w-7xl mx-auto px-10">
            <div>
                <h2 class="text-2xl font-medium text-gray-500">Städte</h2>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                    @foreach($cities as $city)
                        <li class="col-span-1 flex rounded-md shadow-sm">
                            <div
                                class="flex-shrink-0 flex items-center justify-center w-16 bg-amber-500 text-white text-sm font-medium rounded-l-md">
                                {{ str($city->name)->initials() }}
                            </div>
                            <div
                                class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                                <div class="flex-1 truncate px-4 py-2 text-sm">
                                    <a href="#"
                                       class="font-medium text-gray-900 hover:text-gray-600">{{ $city->name }}</a>
                                    <p class="text-gray-500">16 Kurse</p>
                                </div>
                                <div class="flex-shrink-0 pr-2">
                                    {{-- BTN--}}
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

</div>
