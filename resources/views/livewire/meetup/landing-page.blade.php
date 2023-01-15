<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- MAIN --}}
    <section class="w-full mb-12 mt-8">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">
            <div class="flex flex-col sm:flex-row">
                <div class="sm:w-10/12 flex flex-col">
                    <h1 class="mb-6 text-5xl font-extrabold leading-none tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200">{{ $meetup->name }}</span><br
                            class="lg:block hidden">
                        {{ __('Plebs together strong 💪') }}
                    </h1>
                    <div class="px-0 mb-6 text-lg text-gray-200 md:text-xl">
                        <x-markdown>
                            {!! $meetup->intro !!}
                        </x-markdown>
                    </div>

                    <x-button
                        target="_blank"
                        :href="$meetup->link"
                        primary lg class="mt-4 whitespace-nowrap">
                        <i class="fa fa-thin fa-external-link mr-2"></i>
                        {{ __('Link') }}
                    </x-button>
                </div>

                <div class="sm:w-2/12 p-4">
                    <img class="max-h-64" src="{{ $meetup->getFirstMediaUrl('logo') }}" alt="Logo">
                </div>
            </div>

        </div>

        <div class="w-full">

            @php
                $locale = \Illuminate\Support\Facades\Cookie::get('lang', 'de');
            @endphp

            <link rel="stylesheet" type="text/css"
                  href="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.css"/>
            <script src="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.js"></script>
            <script src="https://unpkg.com/js-year-calendar@latest/locales/js-year-calendar.{{ $locale }}.js"></script>

            <style>
                .calendar .calendar-header {
                    background-color: #F7931A;
                    color: white;
                    border: 0;
                }

                .calendar table.month th.month-title {
                    color: #F7931A;
                }

                .calendar table.month th.day-header {
                    color: #fff;
                }

                .calendar table.month td.day .day-content {
                    color: #fff;
                }

                .calendar .calendar-header table th:hover {
                    background: #222;
                }
            </style>
            <div
                wire:ignore
                x-data="{
                                calendar: null,
                                init() {
                                    let events = {{ Js::from($events) }};
                                    events = events.map(function(e){
                                        return {id: e.id, startDate: new Date(e.startDate), endDate: new Date(e.endDate), location: e.location, description: e.description}
                                    })

                                    new Calendar(this.$refs.calendar, {
                                        style: 'background',
                                        language: '{{ $locale }}',
                                        startYear: {{ date('Y') }},
                                        dataSource: events,
                                        yearChanged: function(e) {
                                            @this.set('year', e.currentYear);
                                        },
                                    });
                                },
                            }"
            >
                <div x-ref="calendar"></div>
            </div>

            <div class="p-4 w-full flex justify-end">
                <x-button :href="route('welcome')" primary lg class="whitespace-nowrap">
                    <i class="fa fa-thin fa-arrow-left mr-2"></i>
                    {{ __('Back') }}
                </x-button>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
