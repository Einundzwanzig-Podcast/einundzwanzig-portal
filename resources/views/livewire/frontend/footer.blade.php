<div class="py-6 bg-gray-900 w-full">
    <div class="px-10 mx-auto max-w-7xl">
        <div class="flex flex-col items-center md:flex-row md:justify-between">
            <a href="/">
                <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}"
                     class="text-white fill-current" alt="">
            </a>

            <div class="flex flex-row justify-center mb-4 -ml-4 -mr-4">
                <a href="#"
                   class="p-4 text-gray-700 hover:text-gray-400">

                </a>
                <a href="#" class="p-4 text-gray-700 hover:text-gray-400">

                </a>
                <a href="#" class="p-4 text-gray-700 hover:text-gray-400">

                </a>
            </div>
        </div>
        <div class="flex flex-col justify-between text-center md:flex-row">
            <p class="order-last text-sm leading-tight text-gray-500 md:order-first">
                {{ __('Built with ❤️ by our team.') }}
            </p>
            <ul class="flex flex-col sm:flex-row justify-center pb-3 -ml-4 -mr-4 text-sm">
                <li>
                    <a href="https://github.com/affektde/einundzwanzig-bitcoin-school" target="_blank"
                       class="px-4 text-gray-500 hover:text-white">
                        <i class="fa fab fa-github mr-1"></i>
                        {{ __('Github') }}
                    </a>
                </li>
                <li>
                    <a href="https://bitcoin.productlift.dev/t/wunschzettel" target="_blank"
                       class="px-4 text-gray-500 hover:text-white">
                        <i class="fa fa-thin fa-thought-bubble mr-1"></i>
                        {{ __('Wish List/Feedback') }}
                    </a>
                </li>
                <li>
                    <a href="/languages/{{ $language->language }}/translations" target="_blank"
                       class="px-4 text-gray-500 hover:text-white">
                        <i class="fa fa-thin fa-language mr-1"></i>
                        {{ __('Translate (:lang :percent%)', ['lang' => $language->name ? $language->name : $language->language, 'percent' => $percentTranslated]) }}
                    </a>
                </li>
                <li>
                    <a data-productlift-sidebar="c7a0077f-a870-4023-b202-9395b17d6870"
                       class="px-4 text-gray-500 hover:text-white cursor-pointer">
                        <i class="fa fa-thin fa-code mr-1"></i>
                        {{ __('Changelog') }}
                    </a>
                </li>
                {{--                <li><a href="#_" class="px-4 text-gray-500 hover:text-white">FAQ's</a></li>--}}
                {{--                <li><a href="#_" class="px-4 text-gray-500 hover:text-white">Terms</a></li>--}}
            </ul>
        </div>
    </div>
</div>
