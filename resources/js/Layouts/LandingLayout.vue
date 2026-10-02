<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import CookieConsent from '@/Components/CookieConsent.vue';
import { openCookieSettings } from '@/lib/analytics';
import { urlLegal } from '@/lib/publicUrls';
import { telHref, whatsappHref } from '@/lib/phone';

const props = defineProps<{
    stickyMobileCta?: boolean;
}>();

const { t } = useI18n();
const page = usePage();

const locale = computed(() => page.props.locale as string);
const site = computed(() => page.props.site as {
    name: string;
    telefono?: string;
    whatsapp?: string;
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50">
        <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 shadow-sm backdrop-blur-md">
            <div class="container-public flex h-16 items-center justify-between gap-4">
                <Link href="/" class="block shrink-0">
                    <ApplicationLogo class="h-9 w-auto fill-current text-brand-950" />
                </Link>

                <div class="flex shrink-0 items-center gap-2">
                    <a
                        v-if="site.telefono"
                        :href="telHref(site.telefono)"
                        class="btn-primary hidden px-4 py-2 text-sm sm:inline-flex"
                    >
                        {{ t('landing.call') }}
                    </a>
                    <a
                        v-if="site.whatsapp"
                        :href="whatsappHref(site.whatsapp)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-outline hidden px-4 py-2 text-sm sm:inline-flex"
                    >
                        WhatsApp
                    </a>
                    <a
                        v-if="site.telefono"
                        :href="telHref(site.telefono)"
                        class="btn-primary px-3 py-2 text-xs sm:hidden"
                        :aria-label="t('landing.call')"
                    >
                        {{ t('landing.call') }}
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1" :class="props.stickyMobileCta ? 'pb-24 md:pb-0' : undefined">
            <slot />
        </main>

        <div
            v-if="props.stickyMobileCta && (site.telefono || site.whatsapp)"
            class="fixed bottom-0 left-0 right-0 z-50 grid grid-cols-2 gap-0 border-t border-slate-200 bg-white p-2 shadow-[0_-4px_20px_rgba(0,0,0,0.08)] md:hidden"
        >
            <a
                v-if="site.telefono"
                :href="telHref(site.telefono)"
                class="btn-primary rounded-xl py-3 text-center text-sm"
            >
                {{ t('landing.call_now') }}
            </a>
            <a
                v-if="site.whatsapp"
                :href="whatsappHref(site.whatsapp)"
                target="_blank"
                rel="noopener noreferrer"
                class="btn-outline rounded-xl py-3 text-center text-sm"
            >
                WhatsApp
            </a>
        </div>

        <footer class="border-t border-slate-200 bg-white py-8">
            <div class="container-public text-center text-sm text-slate-500">
                <p>&copy; {{ new Date().getFullYear() }} {{ site.name }}</p>
                <p class="mt-2 flex flex-wrap items-center justify-center gap-x-3 gap-y-1">
                    <Link :href="urlLegal(locale, 'aviso-legal')" class="hover:text-brand-600">{{ t('footer.legal_notice') }}</Link>
                    <span class="text-slate-300" aria-hidden="true">·</span>
                    <Link :href="urlLegal(locale, 'privacidad')" class="hover:text-brand-600">{{ t('footer.privacy') }}</Link>
                    <span class="text-slate-300" aria-hidden="true">·</span>
                    <Link :href="urlLegal(locale, 'cookies')" class="hover:text-brand-600">{{ t('footer.cookies') }}</Link>
                    <span class="text-slate-300" aria-hidden="true">·</span>
                    <button type="button" class="hover:text-brand-600" @click="openCookieSettings">
                        {{ t('cookies.manage') }}
                    </button>
                </p>
            </div>
        </footer>

        <CookieConsent />
    </div>
</template>
