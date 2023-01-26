import Echo from 'laravel-echo'

import Pusher from 'pusher-js'

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
window.Pusher = Pusher

window.Echo = new Echo({
    broadcaster:       'pusher',
    key:               import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost:            import.meta.env.VITE_PUSHER_HOST,
    wsPort:            import.meta.env.VITE_PUSHER_PORT,
    wssPort:           import.meta.env.VITE_PUSHER_PORT,
    forceTLS:          true,
    encrypted:         true,
    disableStats:      true,
    enabledTransports: [
        'ws',
        'wss'
    ],
})
