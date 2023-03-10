<div>
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="container p-4 mx-auto bg-21gray my-2">

        <div class="pb-5 flex flex-row justify-between">
            <h3 class="text-lg font-medium leading-6 text-gray-200">{{ __('Voting') }}
                : {{ $projectProposal->name }}</h3>
            <div class="flex flex-row space-x-2 items-center">
                <div>
                    <x-button :href="$fromUrl">
                        <i class="fa fa-thin fa-arrow-left"></i>
                        {{ __('Back') }}
                    </x-button>
                </div>
            </div>
        </div>

        <form class="space-y-8 divide-y divide-gray-700 pb-24">
            <div class="space-y-8 divide-y divide-gray-700 sm:space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">

                    <div>
                        <div class="border-b border-gray-200 bg-dark px-4 py-5 sm:px-6">
                            <h3 class="text-base font-semibold leading-6 text-gray-200">{{ __('Description') }}</h3>
                        </div>

                        <div class="prose prose-invert leading-normal">
                            <x-markdown>
                                {!! $projectProposal->description !!}
                            </x-markdown>
                        </div>
                    </div>

                    <div class="sm:mt-5 space-y-6 sm:space-y-5">
                        <div class="w-full flex space-x-4">
                            <x-button lg primary wire:click="yes">
                                Yes, support it!
                            </x-button>
                            <x-button lg primary wire:click="no">
                                No, don't support it!
                            </x-button>
                        </div>

                        <div>
                            <x-input.group :for="md5('vote.reason')" :label="__('Reason')">
                                <x-textarea autocomplete="off" wire:model.debounce="vote.reason"
                                            :placeholder="__('Reason')"/>
                            </x-input.group>
                        </div>

                        <div wire:ignore>
                            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

                            <div
                                x-data="{
                            yes: [{{ $entitledVoters->pluck('votes')->collapse()->where('value', 1)->count() }},{{ $otherVoters->pluck('votes')->collapse()->where('value', 1)->count() }}],
                            no: [{{ $entitledVoters->pluck('votes')->collapse()->where('value', 0)->count() }},{{ $otherVoters->pluck('votes')->collapse()->where('value', 0)->count() }}],
                            labels: ['{{ __('Entitled voters') }}', '{{ __('Other voters') }}',],
                            init() {
                                let chart = new ApexCharts(this.$refs.chart, this.options)
                                chart.render()
                                this.$watch('valuesEligible', () => {
                                    chart.updateOptions(this.options)
                                })
                                this.$watch('valuesOther', () => {
                                    chart.updateOptions(this.options)
                                })
                            },
                            get options() {
                                return {
                                    theme: { palette: 'palette3' },
                                    chart: { type: 'bar', toolbar: true, height: 200, stacked: true, stackType: '100%'},
                                    xaxis: { categories: this.labels },
                                    plotOptions: { bar: { horizontal: true } },
                                    series: [
                                        {
                                            name: 'Yes',
                                            data: this.yes,
                                        },
                                        {
                                            name: 'No',
                                            data: this.no,
                                        },
                                    ],
                                }
                            }
                        }"
                                class="w-full"
                            >
                                <div x-ref="chart" class="rounded-lg bg-white p-8"></div>
                            </div>
                        </div>

                        <div class="w-full grid grid-cols-2">

                            <div>
                                <div class="border-b border-gray-200 bg-dark px-4 py-5 sm:px-6">
                                    <h3 class="text-base font-semibold leading-6 text-gray-200">{{ __('Entitled voters') }}</h3>
                                </div>

                                <ul role="list" class="divide-y divide-gray-200">

                                    @foreach($entitledVoters as $voter)
                                        @php
                                            $vote = $voter->votes->first();
                                            if (!$voter->votes->first()) {
                                                $text = __('not voted yet');
                                            } elseif (!$vote->value) {
                                                $text = __('Reason') . ': ' . $voter->votes->first()?->reason;
                                            }
                                        @endphp
                                        <li class="flex py-4">
                                            <img class="h-10 w-10 rounded-full" src="{{ $voter->profile_photo_url }}"
                                                 alt="">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-200">
                                                    {{ $voter->name }}
                                                    @if($voter->votes->first()?->value)
                                                        <x-badge green>{{ __('Yes') }}</x-badge>
                                                    @endif
                                                    @if($voter->votes->first() && !$voter->votes->first()?->value)
                                                        <x-badge red>{{ __('No') }}</x-badge>
                                                    @endif
                                                </p>
                                                <p class="text-sm text-gray-300">
                                                    {{ $text ?? '' }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                            <div>
                                <div class="border-b border-gray-200 bg-dark px-4 py-5 sm:px-6">
                                    <h3 class="text-base font-semibold leading-6 text-gray-200">{{ __('Other voters') }}</h3>
                                </div>

                                <ul role="list" class="divide-y divide-gray-200">

                                    @foreach($otherVoters as $voter)
                                        @php
                                            $vote = $voter->votes->first();
                                            if (!$voter->votes->first()) {
                                                $text = __('not voted yet');
                                            } elseif (!$vote->value) {
                                                $text = __('Reason') . ': ' . $voter->votes->first()?->reason;
                                            }
                                        @endphp
                                        <li class="flex py-4">
                                            <img class="h-10 w-10 rounded-full" src="{{ $voter->profile_photo_url }}"
                                                 alt="">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-200">
                                                    {{ $voter->name }}
                                                    @if($voter->votes->first()?->value)
                                                        <x-badge green>{{ __('Yes') }}</x-badge>
                                                    @endif
                                                    @if($voter->votes->first() && !$voter->votes->first()?->value)
                                                        <x-badge red>{{ __('No') }}</x-badge>
                                                    @endif
                                                </p>
                                                <p class="text-sm text-gray-300">
                                                    {{ $text ?? '' }}
                                                </p>
                                            </div>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
</div>
