<script setup lang="ts">
import LandingLayout from '@/Layouts/LandingLayout.vue';
import LandingWorkCarousel from '@/Components/Landing/LandingWorkCarousel.vue';
import LandingQuoteForm from '@/Components/Landing/LandingQuoteForm.vue';
import LandingSectionIcon from '@/Components/Landing/LandingSectionIcon.vue';
import LandingReviewsCarousel from '@/Components/Landing/LandingReviewsCarousel.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { executeRecaptcha } from '@/lib/recaptcha';
import { trackEvent } from '@/lib/analytics';
import { telHref, whatsappHref } from '@/lib/phone';

const { t } = useI18n();

const props = defineProps<{
    landingSlug: string;
    ciudad: string;
    content: {
        h1: string;
        subheadline: Array<{ text: string; emphasis?: boolean }>;
        trust: Array<{ title: string; desc: string; icon: string }>;
        service_blocks: Array<{ title: string; desc: string; icon: string }>;
        steps: Array<{ title: string; desc: string }>;
        reviews: Array<{
            name: string;
            text: string;
            rating?: number;
            relative_time?: string | null;
            profile_url?: string | null;
            photo_url?: string | null;
            source?: string;
        }>;
        default_mensaje: string;
        work_photos: string[];
        hero_background: string | null;
        closing_title: string;
        closing_sub: string;
    };
    servicio: {
        id: number;
        titulo: string;
        meta_title: string;
        meta_description: string;
        imagen_cabecera: string | null;
        imagenes: string[];
    };
    ciudades: Array<{ es: string; en: string }>;
    googleReviewsUrl: string;
    reviewsSource: 'google' | 'manual' | 'sample';
}>();

const zoneOtherValue = computed(() => t('form.zone_other'));
const servicioOpciones = computed(() => props.content.service_blocks.map((b) => b.title));

const serviceGridClass = computed(() => {
    const n = props.content.service_blocks.length;
    if (n <= 1) {
        return 'md:grid-cols-1';
    }
    if (n === 3) {
        return 'md:grid-cols-3';
    }
    return 'md:grid-cols-2';
});

const page = usePage();
const locale = computed(() => page.props.locale as string);
const site = computed(() => page.props.site as { telefono?: string; whatsapp?: string });
const flashSuccess = computed(() => (page.props.flash as { success?: string } | undefined)?.success);
const recaptcha = computed(() => page.props.recaptcha as { site_key: string | null; enabled: boolean });

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    servicio_id: props.servicio.id,
    servicio_detalle: '',
    zona: '',
    mensaje: '',
    recaptcha_token: '',
});

const presupuestoRoute = computed(() => (locale.value === 'en' ? 'en.presupuesto.store' : 'presupuesto.store'));

function cityName(c: { es: string; en: string }) {
    return locale.value === 'en' ? c.en : c.es;
}

async function submit() {
    const detalle = form.servicio_detalle.trim();
    const cuerpo = form.mensaje.trim() || props.content.default_mensaje;

    if (recaptcha.value.enabled && recaptcha.value.site_key) {
        form.recaptcha_token = await executeRecaptcha(recaptcha.value.site_key, 'quote');
    }

    form
        .transform((data) => {
            const mensaje = detalle ? `Servicio solicitado: ${detalle}\n\n${cuerpo}` : cuerpo;

            return {
                nombre: data.nombre,
                email: data.email,
                telefono: data.telefono,
                servicio_id: data.servicio_id,
                zona: data.zona,
                mensaje,
                recaptcha_token: data.recaptcha_token,
            };
        })
        .post(route(presupuestoRoute.value), {
            preserveScroll: true,
            onSuccess: () => {
                trackEvent('generate_lead', {
                    form: 'landing',
                    landing: props.landingSlug,
                    servicio_id: props.servicio.id,
                });
                window.dataLayer = window.dataLayer || [];
                window.dataLayer.push({
                    event: 'form_submit_success',
                    landing_slug: props.landingSlug,
                    servicio_id: props.servicio.id,
                });
                form.reset();
                form.servicio_id = props.servicio.id;
                form.servicio_detalle = '';
            },
        });
}

function scrollToForm() {
    const id = window.matchMedia('(min-width: 1024px)').matches ? 'presupuesto-desktop' : 'presupuesto';
    document.getElementById(id)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<template>
    <Head>
        <title>{{ servicio.meta_title }}</title>
        <meta head-key="description" name="description" :content="servicio.meta_description" />
    </Head>

    <LandingLayout sticky-mobile-cta>
        <section class="relative overflow-hidden border-b border-brand-900">
            <div
                class="absolute inset-0 scale-105 bg-cover bg-center bg-no-repeat"
                :style="content.hero_background ? { backgroundImage: `url(${content.hero_background})` } : undefined"
                role="img"
                :aria-label="servicio.titulo"
            />
            <div class="absolute inset-0 bg-brand-950/45 md:bg-brand-950/40" aria-hidden="true" />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-950/55 via-brand-950/35 to-brand-950/25 md:from-brand-950/50 md:via-brand-950/30 md:to-brand-950/15" aria-hidden="true" />

            <div class="container-public relative z-10 py-10 md:py-14 lg:py-16">
                <div class="grid items-start gap-10 lg:grid-cols-[1fr,min(100%,380px)] lg:gap-12 xl:grid-cols-[1fr,400px]">
                    <div class="max-w-2xl drop-shadow-sm">
                        <h1 class="text-3xl font-bold leading-tight tracking-tight text-white drop-shadow-md md:text-4xl lg:text-[2.5rem] lg:leading-tight">
                            {{ content.h1 }}
                        </h1>
                        <p class="mt-4 text-base text-brand-100 md:text-lg">
                            <template v-for="(part, i) in content.subheadline" :key="i">
                                <span v-if="i > 0" class="text-brand-300/90"> · </span>
                                <strong v-if="part.emphasis" class="font-semibold text-white">{{ part.text }}</strong>
                                <span v-else>{{ part.text }}</span>
                            </template>
                        </p>

                        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                            <a
                                v-if="site.telefono"
                                :href="telHref(site.telefono)"
                                class="btn-primary gap-2 px-8 py-3 text-base"
                            >
                                {{ t('landing.call') }}
                            </a>
                            <a
                                v-if="site.whatsapp"
                                :href="whatsappHref(site.whatsapp)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center gap-2 rounded-full border border-white/35 bg-white/10 px-8 py-3 text-base font-semibold text-white backdrop-blur-sm transition hover:bg-white/20"
                            >
                                WhatsApp
                            </a>
                        </div>
                    </div>

                    <div id="presupuesto-desktop" class="hidden lg:block lg:sticky lg:top-24">
                        <LandingQuoteForm
                            :form="form"
                            :servicio-opciones="servicioOpciones"
                            :ciudades="ciudades"
                            :locale="locale"
                            :zone-other-value="zoneOtherValue"
                            :flash-success="flashSuccess"
                            :recaptcha-enabled="recaptcha.enabled"
                            compact
                            @submit="submit"
                        />
                    </div>
                </div>
            </div>
        </section>

        <section class="border-b border-slate-200 bg-slate-50 py-8">
            <div class="container-public">
                <div class="grid grid-cols-2 gap-3 md:grid-cols-4 md:gap-4">
                    <div
                        v-for="(item, i) in content.trust"
                        :key="i"
                        class="flex flex-col items-center rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm"
                    >
                        <LandingSectionIcon :icon="item.icon" size="sm" class="mb-3" />
                        <p class="text-sm font-bold text-brand-950">{{ item.title }}</p>
                        <p class="mt-1 text-xs leading-snug text-slate-500">{{ item.desc }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-12 md:py-16">
            <div class="container-public">
                <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.services_title') }}</h2>
                <div class="mt-8 hidden gap-4 md:grid" :class="serviceGridClass">
                    <div
                        v-for="(block, i) in content.service_blocks"
                        :key="i"
                        class="card p-6"
                    >
                        <div class="flex items-start gap-4">
                            <LandingSectionIcon :icon="block.icon" />
                            <div>
                                <h3 class="text-lg font-semibold text-brand-950">{{ block.title }}</h3>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ block.desc }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-6 space-y-2 md:hidden">
                    <details
                        v-for="(block, i) in content.service_blocks"
                        :key="i"
                        class="group rounded-xl border border-slate-200 bg-white"
                    >
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-3 font-semibold text-brand-950">
                            <span class="flex min-w-0 items-center gap-3">
                                <LandingSectionIcon :icon="block.icon" size="sm" />
                                <span class="truncate">{{ block.title }}</span>
                            </span>
                            <span class="shrink-0 text-slate-400 transition group-open:rotate-180">▼</span>
                        </summary>
                        <p class="border-t border-slate-100 px-4 pb-4 pt-2 text-sm text-slate-600">{{ block.desc }}</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="border-y border-slate-200 bg-brand-50/50 py-12 md:py-16">
            <div class="container-public">
                <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.process_title') }}</h2>
                <div class="mt-8 grid gap-4 md:grid-cols-3">
                    <div
                        v-for="(step, i) in content.steps"
                        :key="i"
                        class="card flex gap-4 p-6"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-lg font-bold text-white">
                            {{ i + 1 }}
                        </span>
                        <div>
                            <h3 class="font-semibold text-brand-950">{{ step.title }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ step.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <LandingWorkCarousel :photos="content.work_photos" :alt-label="t('landing.photo_work')" />

        <LandingReviewsCarousel
            :reviews="content.reviews"
            :google-reviews-url="googleReviewsUrl"
            :show-sample-note="reviewsSource === 'sample'"
        />

        <section class="py-12 md:py-16">
            <div class="container-public">
                <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.coverage_title') }}</h2>
                <div class="mt-6 flex flex-wrap gap-2">
                    <span
                        v-for="(c, i) in ciudades"
                        :key="i"
                        class="rounded-full border border-brand-200 bg-brand-50 px-4 py-2 text-sm font-medium text-brand-800"
                    >
                        {{ cityName(c) }}
                    </span>
                </div>
            </div>
        </section>

        <section class="border-t border-brand-200 bg-brand-950 py-10 text-white">
            <div class="container-public flex flex-col items-center gap-6 text-center md:flex-row md:justify-between md:text-left">
                <div>
                    <p class="text-xl font-bold">{{ content.closing_title }}</p>
                    <p class="mt-1 text-brand-200">{{ content.closing_sub }}</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
                    <a v-if="site.telefono" :href="telHref(site.telefono)" class="btn-primary px-8 py-3">{{ t('landing.call') }}</a>
                    <a
                        v-if="site.whatsapp"
                        :href="whatsappHref(site.whatsapp)"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-outline border-white/30 bg-transparent px-8 py-3 text-white hover:bg-white/10"
                    >
                        WhatsApp
                    </a>
                    <button type="button" class="btn-outline border-white/30 bg-transparent px-8 py-3 text-white hover:bg-white/10 md:hidden" @click="scrollToForm">
                        {{ t('landing.cta_quote_short') }}
                    </button>
                </div>
            </div>
        </section>

        <section id="presupuesto" class="border-t border-slate-200 bg-white py-12 lg:hidden">
            <div class="container-public">
                <LandingQuoteForm
                    :form="form"
                    :servicio-opciones="servicioOpciones"
                    :ciudades="ciudades"
                    :locale="locale"
                    :zone-other-value="zoneOtherValue"
                    :recaptcha-enabled="recaptcha.enabled"
                    compact
                    @submit="submit"
                />
            </div>
        </section>
    </LandingLayout>
</template>
