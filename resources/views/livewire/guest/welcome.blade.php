<div>
    <section class="w-full">
        <div class="max-w-7xl mx-auto px-10">
            <div class="flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-7xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="#_"
                       class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Städte</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Dozenten</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Kurse</a>
                        <a href="#_" class="mr-5 font-medium leading-6 text-gray-400 hover:text-gray-300">Termine</a>
                    </nav>
                </div>
                <div class="inline-flex items-center ml-5 text-lg space-x-6 lg:justify-end">
                    <a href="{{ route('nova.login') }}"
                       class="text-base font-medium leading-6 text-gray-400 hover:text-gray-300 whitespace-no-wrap transition duration-150 ease-in-out">
                        Login
                    </a>
                    <a href="#"
                       class="inline-flex items-center justify-center px-4 py-2 font-medium leading-6 text-gray-200 hover:text-white whitespace-no-wrap bg-gray-800 border border-transparent rounded shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                        Registrieren
                    </a>
                </div>
            </div>
            <div class="flex lg:flex-row flex-col pt-4 md:pt-4 lg:pt-4">
                <div
                    class="w-full lg:w-1/2 flex lg:px-0 px-5 flex-col md:items-center lg:items-start justify-center -mt-12">
                    <h1 class="text-white text-3xl sm:text-5xl lg:max-w-none max-w-4xl lg:text-left text-left md:text-center xl:text-7xl font-black">
                        Bitcoin <span
                            class="bg-clip-text text-transparent bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-700 mt-1 lg:block">School</span>
                    </h1>
                    <p class="text-gray-500 sm:text-lg md:text-xl xl:text-2xl lg:max-w-none max-w-2xl md:text-center lg:text-left lg:pr-32 mt-6">
                        Finde Bitcoin Kurse in deiner City</p>
                    <a href="#_"
                       class="bg-white px-12 lg:px-16 py-4 text-center lg:py-5 font-bold rounded text-lg md:text-xl lg:text-2xl mt-8 inline-block w-auto">
                        👇 Kurs finden 👇
                    </a>
                    <p class="text-gray-400 font-normal mt-4">{{-- TEXT --}}</p>
                </div>
                <div class="w-full lg:w-1/2 relative lg:mt-0 mt-20 flex items-center justify-center">
                    {{--<img src="https://cdn.devdojo.com/images/march2022/mesh-gradient1.png"
                         class="absolute lg:max-w-none max-w-3xl mx-auto mt-32 w-full h-full inset-0">--}}
                    <img src="{{ asset('img/btc-logo-6219386_1280.png') }}"
                         class="w-full md:w-auto w-72 max-w-md max-w-sm ml-4 md:ml-20 lg:ml-0 xl:max-w-lg relative">
                </div>
            </div>
        </div>
    </section>

    <section class="w-full mb-12">
        <div class="max-w-7xl mx-auto px-10">
            <div class="border-b border-gray-200 pb-5 sm:pb-0 my-6">
                <h3 class="text-lg font-medium leading-6 text-gray-200">Suche</h3>
                <div class="mt-3 sm:mt-4">
                    <!-- Dropdown menu on small screens -->
                    <div class="sm:hidden">
                        <label for="current-tab" class="sr-only">Select a tab</label>
                        <select id="current-tab" name="current-tab"
                                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                            <option>Städte</option>
                            <option>Dozenten</option>
                            <option>Kurse</option>
                            <option>Termine</option>
                        </select>
                    </div>
                    <!-- Tabs at small breakpoint and up -->
                    <div class="hidden sm:block">
                        <nav class="-mb-px flex space-x-8">
                            <!-- Current: "border-indigo-200 text-indigo-600", Default: "border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300" -->
                            <a href="#"
                               class="border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Städte</a>

                            <a href="#"
                               class="border-amber-500 text-amber-500 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Dozenten</a>

                            <a href="#"
                               class="border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Kurse</a>

                            <a href="#"
                               class="border-transparent text-gray-200 hover:text-gray-400 hover:border-gray-300 whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">Termine</a>
                        </nav>
                    </div>
                </div>
            </div>
            <livewire:tables.lecturer-table/>
        </div>
    </section>

</div>
