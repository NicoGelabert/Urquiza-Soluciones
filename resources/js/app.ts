import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import { createApp, DefineComponent, h } from 'vue';
import { createI18n } from 'vue-i18n';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import es from './lang/es.json';
import en from './lang/en.json';
import { initAnalytics } from './lib/analytics';
import { registerLocaleSync } from './plugins/localeSync';

const appName = import.meta.env.VITE_APP_NAME || 'Urquiza Soluciones';

export const i18n = createI18n({
    legacy: false,
    locale: 'es',
    fallbackLocale: 'es',
    messages: { es, en },
});

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        registerLocaleSync(i18n as Parameters<typeof registerLocaleSync>[0], props.initialPage.props.locale as string | undefined);

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(i18n)
            .use(ZiggyVue)
            .mount(el);

        initAnalytics();
    },
    progress: {
        color: '#2563eb',
    },
});
