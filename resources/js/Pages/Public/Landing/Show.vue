<script setup lang="ts">
import LandingLayout from '@/Layouts/LandingLayout.vue';
import ServiceIcon from '@/Components/Public/ServiceIcon.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { executeRecaptcha } from '@/lib/recaptcha';
import { trackEvent } from '@/lib/analytics';

const { t } = useI18n();

const props = defineProps<{
    landingSlug: string;
    servicio: {
        id: number;
        titulo: string;
        hero_subtitulo: string;
        descripcion_corta: string;
        descripcion_larga: string;
        icono: string;
        meta_title: string;
        meta_description: string;
        items: Array<{ titulo: string }>;
    };
    ciudades: Array<{ es: string; en: string }>;
}>();

const page = usePage();
const locale = computed(() => page.props.locale as string);
const flashSuccess = computed(() => (page.props.flash as { success?: string } | undefined)?.success);
const recaptcha = computed(() => page.props.recaptcha as { site_key: string | null; enabled: boolean });

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    servicio_id: props.servicio.id,
    zona: '',
    mensaje: '',
    recaptcha_token: '',
});

const presupuestoRoute = computed(() => (locale.value === 'en' ? 'en.presupuesto.store' : 'presupuesto.store'));

function loc() {
    return locale.value as 'es' | 'en';
}

async function submit() {
    if (recaptcha.value.enabled && recaptcha.value.site_key) {
        form.recaptcha_token = await executeRecaptcha(recaptcha.value.site_key, 'quote');
    }

    form.post(route(presupuestoRoute.value), {
        preserveScroll: true,
        onSuccess: () => {
            trackEvent('generate_lead', {
                form: 'landing',
                landing: props.landingSlug,
                servicio_id: props.servicio.id,
            });
            // Push para el trigger de GTM
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({
                event: 'form_submit_success',
                landing_slug: props.landingSlug,
                servicio_id: props.servicio.id,
            });
            form.reset();
            form.servicio_id = props.servicio.id;
        },
    });
}
</script>

<template>
    <Head>
        <title>{{ servicio.meta_title }}</title>
        <meta head-key="description" name="description" :content="servicio.meta_description" />
    </Head>

    <LandingLayout>
        <section class="bg-brand-950 py-12 text-white md:py-16">
            <div class="container-public">
                <div class="mx-auto max-w-3xl text-center">
                    <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-800/80 ring-1 ring-white/10">
                        <ServiceIcon :icon="servicio.icono" class="h-8 w-8 text-brand-200" />
                    </div>
                    <p class="text-sm font-semibold uppercase tracking-wider text-brand-300">{{ servicio.hero_subtitulo }}</p>
                    <h1 class="mt-3 text-3xl font-bold tracking-tight md:text-4xl lg:text-5xl">{{ servicio.titulo }}</h1>
                    <p class="mt-4 text-lg leading-relaxed text-brand-100">{{ servicio.descripcion_corta }}</p>
                    <ul class="mt-8 flex flex-wrap items-center justify-center gap-3 text-sm font-medium text-brand-100">
                        <li class="rounded-full bg-white/10 px-4 py-2 ring-1 ring-white/10">{{ t('cta.free_quote') }}</li>
                        <li class="rounded-full bg-white/10 px-4 py-2 ring-1 ring-white/10">{{ t('landing.costa_del_sol') }}</li>
                        <li class="rounded-full bg-white/10 px-4 py-2 ring-1 ring-white/10">{{ t('cta.emergency_24h') }}</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="py-12 md:py-16">
            <div class="container-public">
                <div class="grid gap-12 lg:grid-cols-2 lg:gap-16">
                    <div>
                        <h2 class="text-2xl font-bold text-brand-950">{{ t('service.what_we_offer') }}</h2>
                        <p class="mt-3 text-slate-600">{{ servicio.descripcion_larga }}</p>
                        <ul class="mt-8 space-y-3">
                            <li
                                v-for="(item, i) in servicio.items"
                                :key="i"
                                class="flex gap-3 text-slate-700"
                            >
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                </span>
                                <span>{{ item.titulo }}</span>
                            </li>
                        </ul>
                    </div>

                    <div id="presupuesto">
                        <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.form_title') }}</h2>
                        <p class="mt-2 text-slate-600">{{ t('quote.subtitle') }}</p>

                        <div v-if="flashSuccess" class="mt-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-800 ring-1 ring-green-200">
                            {{ flashSuccess }}
                        </div>

                        <form class="card mt-6 space-y-5 p-6 md:p-8" @submit.prevent="submit">
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.name') }}</label>
                                <input v-model="form.nombre" required class="input-public" />
                            </div>
                            <div class="grid gap-5 sm:grid-cols-2">
                                <div>
                                    <label class="text-sm font-medium text-slate-700">{{ t('form.email') }}</label>
                                    <input v-model="form.email" type="email" required class="input-public" />
                                </div>
                                <div>
                                    <label class="text-sm font-medium text-slate-700">{{ t('form.phone') }}</label>
                                    <input v-model="form.telefono" class="input-public" />
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.zone') }}</label>
                                <select v-model="form.zona" class="input-public">
                                    <option value="">{{ t('form.select') }}</option>
                                    <option v-for="(c, i) in ciudades" :key="i" :value="c[loc()] ?? c.es">{{ c[loc()] ?? c.es }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.describe_need') }}</label>
                                <textarea v-model="form.mensaje" required rows="4" class="input-public" :placeholder="t('form.message_placeholder')" />
                            </div>
                            <p v-if="form.errors.recaptcha_token" class="text-sm text-red-600">{{ form.errors.recaptcha_token }}</p>
                            <button type="submit" :disabled="form.processing" class="btn-primary w-full disabled:opacity-50">
                                {{ t('cta.request_quote') }}
                            </button>
                            <p v-if="recaptcha.enabled" class="text-xs text-slate-400">
                                {{ t('form.recaptcha_notice') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </LandingLayout>
</template>
