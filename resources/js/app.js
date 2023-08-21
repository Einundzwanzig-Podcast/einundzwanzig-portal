import './components'
import './bootstrap'

import Alpine    from 'alpinejs'
import collapse  from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'
import focus     from '@alpinejs/focus'
import NDK, { NDKNip07Signer, NDKEvent } from "@nostr-dev-kit/ndk"

window.Alpine = Alpine
window.NDK = NDK
window.NDKNip07Signer = NDKNip07Signer
window.NDKEvent = NDKEvent

Alpine.plugin(collapse)
Alpine.plugin(intersect)
Alpine.plugin(focus)
Alpine.start()
