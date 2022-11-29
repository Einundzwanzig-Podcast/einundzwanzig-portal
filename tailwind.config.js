const defaultTheme = require('tailwindcss/defaultTheme')

/** @type {import('tailwindcss').Config} */
module.exports = {
    content:  [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    darkMode: 'class',
    theme:    {
        colors:     {
            'gray': {
                DEFAULT: '#151515',
                '50':    '#AEAEAE',
                '100':   '#A4A4A4',
                '200':   '#8F8F8F',
                '300':   '#7B7B7B',
                '400':   '#676767',
                '500':   '#525252',
                '600':   '#3E3E3E',
                '700':   '#292929',
                '800':   '#151515',
                '900':   '#000000'
            },
        },
        extend: {
            fontFamily: {
                sans: [
                    'Nunito',
                    ...defaultTheme.fontFamily.sans
                ],
            },
        },
    },
    plugins:  [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography')
    ],
}
