<script setup lang="ts">
import { computed, onMounted, ref, watch } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import {
    acceptAllCookies,
    cookieBannerVisible,
    cookieSettingsVisible,
    getPreferences,
    needsConsentBanner,
    openCookieSettings,
    rejectAllCookies,
    saveCustomPreferences,
    syncAnalyticsConfig,
} from '@/lib/analytics';
import { urlLegal } from '@/lib/publicUrls';

const { t } = useI18n();
const page = usePage();

const prefsAnalytics = ref(true);
const prefsClarity = ref(true);
const tieneGoogle = ref(false);
const tieneClarity = ref(false);

const locale = computed(() => page.props.locale as string);
const cookiesUrl = computed(() => urlLegal(locale.value, 'cookies'));
const privacyUrl = computed(() => urlLegal(locale.value, 'privacidad'));

onMounted(() => {
    const { google_id, clarity_id } = page.props.analytics as {
        google_id: string | null;
        clarity_id: string | null;
    };

    syncAnalyticsConfig({
        googleId: google_id,
        clarityId: clarity_id,
    });

    tieneGoogle.value = Boolean(google_id);
    tieneClarity.value = Boolean(clarity_id);

    const prefs = getPreferences();
    if (prefs) {
        prefsAnalytics.value = prefs.analytics;
        prefsClarity.value = prefs.clarity;
    }

    cookieBannerVisible.value = needsConsentBanner();
});

watch(cookieSettingsVisible, (abierto) => {
    if (!abierto) {
        return;
    }

    const prefs = getPreferences();
    prefsAnalytics.value = prefs?.analytics ?? true;
    prefsClarity.value = prefs?.clarity ?? true;
});

function aceptar() {
    acceptAllCookies();
}

function rechazar() {
    rejectAllCookies();
}

function gestionar() {
    openCookieSettings();
}

function guardarPreferencias() {
    saveCustomPreferences(
        tieneGoogle.value && prefsAnalytics.value,
        tieneClarity.value && prefsClarity.value,
    );
}

function volverAlBanner() {
    cookieSettingsVisible.value = false;
}

function cerrarAlNavegar() {
    cookieBannerVisible.value = false;
    cookieSettingsVisible.value = false;
}
</script>

<template>
    <Teleport to="body">
        <Transition name="slide-up">
            <div v-if="cookieBannerVisible" class="cookie-consent">
                <div v-if="cookieSettingsVisible" class="cookie-settings">
                    <h3 class="cookie-settings-title">{{ t('cookies.manage_title') }}</h3>
                    <p class="cookie-consent-text">{{ t('cookies.manage_text') }}</p>

                    <div class="cookie-toggle-list">
                        <div class="cookie-toggle-item cookie-toggle-item-disabled">
                            <div>
                                <p class="cookie-toggle-label">{{ t('cookies.technical') }}</p>
                                <p class="cookie-toggle-desc">{{ t('cookies.technical_desc') }}</p>
                            </div>
                            <span class="cookie-toggle-badge">{{ t('cookies.always_on') }}</span>
                        </div>

                        <label class="cookie-toggle-item">
                            <div>
                                <p class="cookie-toggle-label">{{ t('cookies.analytics') }}</p>
                                <p class="cookie-toggle-desc">{{ t('cookies.analytics_desc') }}</p>
                            </div>
                            <input v-model="prefsAnalytics" type="checkbox" class="cookie-toggle-input" :disabled="!tieneGoogle" />
                        </label>

                        <label class="cookie-toggle-item">
                            <div>
                                <p class="cookie-toggle-label">{{ t('cookies.clarity') }}</p>
                                <p class="cookie-toggle-desc">{{ t('cookies.clarity_desc') }}</p>
                            </div>
                            <input v-model="prefsClarity" type="checkbox" class="cookie-toggle-input" :disabled="!tieneClarity" />
                        </label>
                    </div>

                    <div class="cookie-consent-links">
                        <Link :href="cookiesUrl" class="legal-link" @click="cerrarAlNavegar">{{ t('footer.cookies') }}</Link>
                        <span class="text-slate-300">·</span>
                        <Link :href="privacyUrl" class="legal-link" @click="cerrarAlNavegar">{{ t('footer.privacy') }}</Link>
                    </div>

                    <div class="cookie-consent-actions">
                        <button type="button" class="btn-outline text-sm" @click="volverAlBanner">
                            {{ t('cookies.back') }}
                        </button>
                        <button type="button" class="btn-primary text-sm" @click="guardarPreferencias">
                            {{ t('cookies.save') }}
                        </button>
                    </div>
                </div>

                <div v-else>
                    <p class="cookie-consent-text">{{ t('cookies.banner_text') }}</p>

                    <div class="cookie-consent-links">
                        <Link :href="cookiesUrl" class="legal-link" @click="cerrarAlNavegar">{{ t('footer.cookies') }}</Link>
                        <span class="text-slate-300">·</span>
                        <Link :href="privacyUrl" class="legal-link" @click="cerrarAlNavegar">{{ t('footer.privacy') }}</Link>
                    </div>

                    <div class="cookie-consent-actions cookie-consent-actions-main">
                        <button type="button" class="btn-outline text-sm" @click="rechazar">
                            {{ t('cookies.reject_all') }}
                        </button>
                        <button type="button" class="btn-outline text-sm" @click="gestionar">
                            {{ t('cookies.manage') }}
                        </button>
                        <button type="button" class="btn-primary text-sm" @click="aceptar">
                            {{ t('cookies.accept_all') }}
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>
