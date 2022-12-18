import './bootstrap';
import '../css/app.css';
import './pspdfkit-lib/chunk-1373-519b2c2893990874'
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import { VueCarousel } from 'vue-carousel';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Jasaudagar';
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy , VueCarousel)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });




