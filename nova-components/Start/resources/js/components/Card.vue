<template>
    <div class="flex justify-center items-center">
        <div class="w-full">
            <Heading>{{ __('Getting Started') }}</Heading>
            <p class="leading-tight mt-3">
                {{ __('Als Dozent hast du Zugriff auf das Daten-Backend und kannst neue Items anlegen.') }}
            </p>
            <p class="leading-tight mt-3">
                {{ __('Hier ein paar Tipps, wie du am besten startest:') }}
            </p>

            <Card class="mt-8">
                <div class="md:grid md:grid-cols-2">
                    <div class="border-r border-b border-gray-200 dark:border-gray-700">
                        <a target="_blank" :href="cities" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">1.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Stadt suchen und anlegen') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Gehe auf die Seite "Städte" und suche nach der Stadt, in der du die Items anlegen möchtest. Wenn du die Stadt nicht findest, kannst du sie anlegen.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <a target="_blank" :href="venues" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">2.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Veranstaltungs-Ort suchen und anlegen') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Gehe auf die Seite "Veranstaltungs-Orte" und suche nach dem Ort, an dem du die Items anlegen möchtest. Wenn du den Ort nicht findest, kannst du ihn anlegen.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="border-r border-b border-gray-200 dark:border-gray-700">
                        <a target="_blank" :href="lecturers" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">3.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Dozenten-Profil bearbeiten') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Gehe auf die Seite "Dozenten" und suche nach deinem Dozenten-Profil. Wenn du es nicht findest, kannst du es anlegen.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <a target="_blank" :href="courses" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">4.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Kurse anlegen und verwalten') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Gehe auf die Seite "Kurse" und suche nach dem Kurs, den du editieren möchtest. Wenn du den Kurs nicht findest, kannst du ihn anlegen.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div
                        class="border-r md:border-b-0 border-b border-gray-200 dark:border-gray-700"
                    >
                        <a target="_blank" :href="events" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">5.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Termine anlegen und verwalten') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Gehe auf die Seite "Termine" und suche nach dem Termin, den du editieren möchtest. Wenn du den Termin nicht findest, kannst du ihn anlegen.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <div
                        class="md:border-b-0 border-b border-gray-200 dark:border-gray-700"
                    >
                        <a href="#" class="no-underline flex p-6">
                            <div class="flex justify-center w-11 flex-shrink-0 mr-6">
                                <div class="text-4xl text-primary-500 dark:text-primary-600">6.</div>
                            </div>

                            <div>
                                <Heading :level="3">{{ __('Berechtigungen') }}</Heading>
                                <p class="leading-normal mt-3">
                                    {{
                                        __('Wenn Buttons zur Bearbeitung fehlen, dann hast du nicht die nötigen Berechtigungen. Melde dich bei einem der Admins.')
                                    }}
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            </Card>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Help',

    props: {
        card: Object,
    },

    methods: {
        link (path) {
            return `/nova/${path}`
        },
    },

    computed: {
        cities () {
            return this.link('resources/cities')
        },
        venues () {
            return this.link('resources/venues')
        },
        lecturers () {
            return this.link('resources/lecturers')
        },
        courses () {
            return this.link('resources/courses')
        },
        events () {
            return this.link('resources/events')
        },
    },
}
</script>
