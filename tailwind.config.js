const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [
            require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content:  [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',

        './vendor/rappasoft/laravel-livewire-tables/resources/views/**/*.blade.php',

        './vendor/wireui/wireui/resources/**/*.blade.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/View/**/*.php'
    ],
    darkMode: 'class',
    theme:    {
        extend: {
            colors:     {
                '21gray': '#151515',
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
            },
        },
    },
    plugins:  [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
}
