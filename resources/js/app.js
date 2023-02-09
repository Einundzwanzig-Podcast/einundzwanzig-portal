import './bootstrap'

import Alpine    from 'alpinejs'
import collapse  from '@alpinejs/collapse'
import intersect from '@alpinejs/intersect'
import focus     from '@alpinejs/focus'

window.Alpine = Alpine

Alpine.plugin(collapse)
Alpine.plugin(intersect)
Alpine.plugin(focus)
Alpine.start()
