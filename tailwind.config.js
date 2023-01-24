const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets:  [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content:  [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        './app/Http/Livewire/**/*.php',

        './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',

        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],
    darkMode: 'class',
    theme:    {
        extend: {
            colors:     {
                '21gray': '#222',
                'gray':   {
                    '50':  '#f7f7f7',
                    '100': '#e3e3e3',
                    '200': '#c8c8c8',
                    '300': '#a4a4a4',
                    '400': '#818181',
                    '500': '#666666',
                    '600': '#515151',
                    '700': '#434343',
                    '800': '#383838',
                    '900': '#151515',
                },
                'amber':  {
                    '50':  '#FEF3E6',
                    '100': '#FDEAD3',
                    '200': '#FCD3A1',
                    '300': '#FABE75',
                    '400': '#F9A949',
                    '500': '#F7931A',
                    '600': '#F7931A',
                    '700': '#F7931A',
                    '800': '#673B04',
                    '900': '#361F02'
                },
                'yellow':  {
                    '50':  '#FEF3E6',
                    '100': '#FDEAD3',
                    '200': '#FCD3A1',
                    '300': '#FABE75',
                    '400': '#F9A949',
                    '500': '#F7931A',
                    '600': '#F7931A',
                    '700': '#F7931A',
                    '800': '#673B04',
                    '900': '#361F02'
                },
                primary: {
                    '50':  '#FEF3E6',
                    '100': '#FDEAD3',
                    '200': '#FCD3A1',
                    '300': '#FABE75',
                    '400': '#F9A949',
                    '500': '#F7931A',
                    '600': '#F7931A',
                    '700': '#F7931A',
                    '800': '#673B04',
                    '900': '#361F02'
                },
                secondary: {
                    '50':  '#f7f7f7',
                    '100': '#e3e3e3',
                    '200': '#c8c8c8',
                    '300': '#a4a4a4',
                    '400': '#818181',
                    '500': '#666666',
                    '600': '#515151',
                    '700': '#434343',
                    '800': '#383838',
                    '900': '#151515',
                },
                positive: colors.emerald,
                negative: colors.red,
                warning: colors.amber,
                info: colors.blue,
            },
            fontFamily: {
                sans: [
                    'Inconsolata',
                    ...defaultTheme.fontFamily.sans
                ],
                mono: [
                    'Inconsolata',
                    ...defaultTheme.fontFamily.mono
                ],
                article: [
                    'Nunito',
                    ...defaultTheme.fontFamily.sans
                ],
            },
        },
    },
    plugins:  [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
    ],
}
