import './bootstrap'

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import Clipboard from '@ryangjchandler/alpine-clipboard'
import hljs from 'highlight.js/lib/core';
import php from 'highlight.js/lib/languages/php';

hljs.registerLanguage('php', php);
hljs.highlightAll()
Alpine.plugin(Clipboard)
window.Alpine = Alpine

Alpine.plugin( focus )

Alpine.start()
