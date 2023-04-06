<div class="bg-gray-900 py-12 sm:py-24">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <dl class="grid grid-cols-1 gap-x-8 gap-y-16 text-center lg:grid-cols-2">
            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-400">
                    {{ __('Book cases orange pilled') }}
                </dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">
                    {{ number_format($orangePills, 0, ',', '.') }}
                </dd>
            </div>

            <div class="mx-auto flex max-w-xs flex-col gap-y-4">
                <dt class="text-base leading-7 text-gray-400">
                    {{ __('Number of plebs') }}
                </dt>
                <dd class="order-first text-3xl font-semibold tracking-tight text-white sm:text-5xl">
                    {{ number_format($plebs, 0, ',', '.') }}
                </dd>
            </div>
        </dl>
    </div>
</div>
