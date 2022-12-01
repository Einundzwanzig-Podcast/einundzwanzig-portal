<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-21gray overflow-hidden shadow-xl sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    @if(auth()->user()->is_lecturer)
                        <div
                            class="relative flex items-center space-x-3 rounded-lg border border-amber-300 bg-21gray px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-amber-500 focus-within:ring-offset-2 hover:border-amber-400">
                            <div class="min-w-0 flex-1">
                                <a href="/nova" target="_blank" class="focus:outline-none">
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                    <p class="text-sm font-medium text-gray-200">Kurs anlegen</p>
                                    <p class="truncate text-sm text-gray-300">Zugriff auf das Daten-Backend</p>
                                </a>
                            </div>
                        </div>
                    @endif
                    <div
                        class="relative flex items-center space-x-3 rounded-lg border border-amber-300 bg-21gray px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-amber-500 focus-within:ring-offset-2 hover:border-amber-400">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('profile.show') }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-200">Profil</p>
                                <p class="truncate text-sm text-gray-300">Vervollständige dein Profil</p>
                            </a>
                        </div>
                    </div>
                    <div
                        class="relative flex items-center space-x-3 rounded-lg border border-amber-300 bg-21gray px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-amber-500 focus-within:ring-offset-2 hover:border-amber-400">
                        <div class="min-w-0 flex-1">
                            <a href="{{ route('search.course', ['country' => 'de']) }}" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                <p class="text-sm font-medium text-gray-200">Übersicht der Kurse</p>
                                <p class="truncate text-sm text-gray-300">Zeige das Benutzer Frontend</p>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
