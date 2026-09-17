import { router } from '@inertiajs/vue3';
import type { I18n } from 'vue-i18n';

type AppLocale = 'es' | 'en';

function setGlobalLocale(i18n: I18n, next: AppLocale): void {
    const current = i18n.global.locale as AppLocale | { value: AppLocale };

    if (typeof current === 'string') {
        if (current !== next) {
            (i18n.global as { locale: AppLocale }).locale = next;
        }
        return;
    }

    if (current.value !== next) {
        current.value = next;
    }
}

export function syncI18nLocale(i18n: I18n, locale?: string): void {
    const next = (locale === 'en' ? 'en' : 'es') as AppLocale;
    setGlobalLocale(i18n, next);
    document.documentElement.lang = next;
}

export function registerLocaleSync(i18n: I18n, initialLocale?: string): void {
    syncI18nLocale(i18n, initialLocale);

    router.on('success', (event) => {
        syncI18nLocale(i18n, event.detail.page.props.locale as string | undefined);
    });
}
