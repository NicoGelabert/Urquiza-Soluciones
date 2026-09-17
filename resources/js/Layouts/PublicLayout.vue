<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, nextTick, onMounted, onUnmounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import CookieConsent from '@/Components/CookieConsent.vue';
import MobileMenu from '@/Components/Public/MobileMenu.vue';
import {
    urlContact,
    urlHome,
    urlLegal,
    urlQuote,
    urlServices,
} from '@/lib/publicUrls';
import { telHref, whatsappHref } from '@/lib/phone';

const props = defineProps<{
    transparentHeader?: boolean;
}>();

const { t } = useI18n();
const page = usePage();
const mobileOpen = ref(false);
const heroInView = ref(false);

const locale = computed(() => page.props.locale as string);
const site = computed(() => page.props.site as {
    name: string;
    telefono?: string;
    whatsapp?: string;
    instagram?: string;
    email?: string;
    telefono_urgencias?: string;
});

const isOverHero = computed(() => props.transparentHeader && heroInView.value);

const navLinks = computed(() => [
    { href: urlHome(locale.value), label: t('nav.home') },
    { href: urlServices(locale.value), label: t('nav.services') },
    { href: urlContact(locale.value), label: t('nav.contact') },
    { href: urlQuote(locale.value), label: t('nav.quote') },
]);

const switchLocaleUrl = computed(() => (locale.value === 'en' ? '/' : '/en'));

let scrollListener: (() => void) | null = null;
let removeInertiaListener: (() => void) | null = null;

function checkHeroVisibility() {
    if (!props.transparentHeader) {
        heroInView.value = false;
        return;
    }

    const hero = document.querySelector('[data-site-hero]');
    if (!hero) {
        heroInView.value = false;
        return;
    }

    heroInView.value = hero.getBoundingClientRect().bottom > 0;
}

function bindHeroScroll() {
    scrollListener?.();
    scrollListener = null;

    if (!props.transparentHeader) {
        heroInView.value = false;
        return;
    }

    heroInView.value = true;
    checkHeroVisibility();

    const onScroll = () => checkHeroVisibility();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
    scrollListener = () => {
        window.removeEventListener('scroll', onScroll);
        window.removeEventListener('resize', onScroll);
    };
}

function closeMobile() {
    mobileOpen.value = false;
}

watch(mobileOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});

onMounted(() => {
    bindHeroScroll();
    removeInertiaListener = router.on('success', () => {
        closeMobile();
        nextTick(bindHeroScroll);
    });
});

onUnmounted(() => {
    document.body.style.overflow = '';
    scrollListener?.();
    removeInertiaListener?.();
});
</script>

<template>
    <div class="flex min-h-screen flex-col bg-slate-50">
        <header
            class="sticky top-0 z-40 transition-[background-color,border-color,box-shadow] duration-300 ease-out"
            :class="
                isOverHero
                    ? 'border-b border-white/10 bg-transparent shadow-none backdrop-blur-md'
                    : 'border-b border-slate-200/80 bg-white/90 shadow-sm backdrop-blur-md'
            "
        >
            <div class="container-public flex h-16 items-center justify-between">
                <Link :href="urlHome(locale)" class="block shrink-0">
                    <ApplicationLogo
                        class="h-9 w-auto fill-current transition-colors duration-300"
                        :class="isOverHero ? 'text-white' : 'text-brand-950'"
                    />
                </Link>

                <nav class="hidden items-center gap-1 md:flex">
                    <Link
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="rounded-lg px-3 py-2 text-sm font-medium transition duration-300"
                        :class="
                            isOverHero
                                ? 'text-white hover:bg-white/10 hover:text-white'
                                : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700'
                        "
                    >
                        {{ link.label }}
                    </Link>
                    <a
                        v-if="site.telefono_urgencias"
                        :href="telHref(site.telefono_urgencias)"
                        class="ml-2 inline-flex items-center gap-1.5 rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ t('cta.call_emergency') }}
                    </a>
                    <Link
                        :href="switchLocaleUrl"
                        class="ml-2 rounded-lg px-3 py-2 text-sm font-medium transition duration-300"
                        :class="
                            isOverHero
                                ? 'text-white/80 hover:text-white'
                                : 'text-slate-400 hover:text-brand-600'
                        "
                    >
                        {{ locale === 'es' ? 'EN' : 'ES' }}
                    </Link>
                </nav>

                <button
                    type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-lg transition-colors duration-300 md:hidden"
                    :class="isOverHero && !mobileOpen ? 'text-white' : 'text-slate-600'"
                    :aria-label="t('menu.open')"
                    :aria-expanded="mobileOpen"
                    @click="mobileOpen = true"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </header>

        <MobileMenu
            v-model="mobileOpen"
            :home-url="urlHome(locale)"
            :switch-locale-url="switchLocaleUrl"
            :locale-label="locale === 'es' ? 'EN' : 'ES'"
            :nav-links="navLinks"
            :whatsapp="site.whatsapp"
            :instagram="site.instagram"
            :telefono-urgencias="site.telefono_urgencias"
            :emergency-label="t('cta.call_emergency')"
            :whatsapp-label="t('menu.whatsapp')"
            :instagram-label="t('menu.instagram')"
            :close-label="t('menu.close')"
        />

        <main class="flex-1">
            <slot />
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="container-public py-12">
                <div class="grid gap-10 md:grid-cols-3">
                    <div>
                        <p class="text-lg font-bold text-brand-950">{{ site.name }}</p>
                        <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ t('footer.tagline') }}</p>
                    </div>
                    <div>
                        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400">{{ t('footer.contact') }}</p>
                        <ul class="space-y-2 text-sm text-slate-600">
                            <li v-if="site.telefono">
                                <a :href="telHref(site.telefono)" class="hover:text-brand-600">{{ site.telefono }}</a>
                            </li>
                            <li v-if="site.email">
                                <a :href="`mailto:${site.email}`" class="hover:text-brand-600">{{ site.email }}</a>
                            </li>
                            <li v-if="site.whatsapp">
                                <a :href="whatsappHref(site.whatsapp)" target="_blank" rel="noopener" class="hover:text-brand-600">WhatsApp</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <p class="mb-3 text-sm font-semibold uppercase tracking-wider text-slate-400">{{ t('footer.legal') }}</p>
                        <ul class="space-y-2 text-sm">
                            <li><Link :href="urlLegal(locale, 'aviso-legal')" class="text-slate-600 hover:text-brand-600">{{ t('footer.legal_notice') }}</Link></li>
                            <li><Link :href="urlLegal(locale, 'privacidad')" class="text-slate-600 hover:text-brand-600">{{ t('footer.privacy') }}</Link></li>
                            <li><Link :href="urlLegal(locale, 'cookies')" class="text-slate-600 hover:text-brand-600">{{ t('footer.cookies') }}</Link></li>
                        </ul>
                    </div>
                </div>
                <div class="mt-10 border-t border-slate-100 pt-6 text-center text-sm text-slate-400">
                    &copy; {{ new Date().getFullYear() }} {{ site.name }}
                    <span> — {{ t('footer.design_by') }} </span>
                    <a
                        href="https://chimicreativo.es"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-slate-500 transition hover:text-brand-600"
                    >
                        Chimi Creativo
                    </a>
                </div>
            </div>
        </footer>

        <a
            v-if="site.telefono_urgencias"
            :href="telHref(site.telefono_urgencias)"
            class="fixed bottom-6 right-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-red-600 text-white shadow-lg shadow-red-600/30 transition hover:bg-red-700 md:hidden"
            :aria-label="t('cta.call_emergency')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
        </a>

        <CookieConsent />
    </div>
</template>
