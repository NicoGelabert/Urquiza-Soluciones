<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import FaqAccordion from '@/Components/Public/FaqAccordion.vue';
import HeroSlider from '@/Components/Public/HeroSlider.vue';
import SectionHeading from '@/Components/Public/SectionHeading.vue';
import ServiceIcon from '@/Components/Public/ServiceIcon.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { urlContact, urlQuote, urlService } from '@/lib/publicUrls';
import { telHref } from '@/lib/phone';

const { t } = useI18n();
const page = usePage();
const locale = computed(() => page.props.locale as string);
const activeTab = ref(0);

defineProps<{
    servicios: Array<{
        id: number;
        slug: string;
        titulo: string;
        hero_subtitulo: string | null;
        descripcion_corta: string;
        imagen_cabecera: string | null;
        icono: string | null;
        items: string[];
    }>;
    sobreNosotros: { titulo: string | null; contenido: string | null } | null;
    zonaTrabajo: { titulo: string | null; datos_extra?: { ciudades?: Array<{ es: string; en: string }> } } | null;
    serviciosIntro: {
        titulo: string | null;
        datos_extra?: {
            items?: Array<{ titulo: Record<string, string>; contenido: Record<string, string> }>;
        };
    } | null;
    urgencias: { titulo: string | null } | null;
    faqTitulo: string | null;
    faqs: Array<{ id: number; servicio: string | null; pregunta: string; respuesta: string }>;
    contacto: { telefono?: string; whatsapp?: string; email?: string; telefono_urgencias?: string };
}>();

function loc() {
    return locale.value as 'es' | 'en';
}
</script>

<template>
    <PublicLayout transparent-header>
        <HeroSlider :slides="servicios" :locale="locale" />

        <!-- Servicios con tabs -->
        <section class="py-20">
            <div class="container-public">
                <SectionHeading :title="t('home.services_detail')" centered class="mb-12" />

                <div class="mb-6 flex flex-wrap justify-center gap-2">
                    <button
                        v-for="(servicio, i) in servicios"
                        :key="servicio.id"
                        type="button"
                        class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition"
                        :class="activeTab === i
                            ? 'bg-brand-600 text-white shadow-md shadow-brand-600/20'
                            : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:bg-brand-50 hover:text-brand-700'"
                        @click="activeTab = i"
                    >
                        <ServiceIcon :icon="servicio.icono" class="h-4 w-4" />
                        {{ servicio.titulo }}
                    </button>
                </div>

                <div v-if="servicios[activeTab]" class="card p-8 md:p-10">
                    <div class="mb-6 flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-brand-950">{{ servicios[activeTab].titulo }}</h3>
                            <p class="mt-2 text-slate-500">{{ servicios[activeTab].descripcion_corta }}</p>
                        </div>
                        <div class="hidden rounded-xl bg-brand-50 p-3 text-brand-600 sm:block">
                            <ServiceIcon :icon="servicios[activeTab].icono" class="h-8 w-8" />
                        </div>
                    </div>
                    <ul class="grid gap-3 sm:grid-cols-2">
                        <li
                            v-for="(item, i) in servicios[activeTab].items"
                            :key="i"
                            class="flex items-start gap-3 text-sm text-slate-600"
                        >
                            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-100 text-brand-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                            </span>
                            {{ item }}
                        </li>
                    </ul>
                    <div class="mt-8 flex flex-wrap gap-4">
                        <Link :href="urlService(locale, servicios[activeTab].slug)" class="btn-primary">
                            {{ t('cta.view_service') }}
                        </Link>
                        <Link :href="urlQuote(locale)" class="btn-outline">
                            {{ t('cta.request_quote') }}
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Intro servicios -->
        <section v-if="serviciosIntro" class="bg-white py-20">
            <div class="container-public">
                <SectionHeading :title="serviciosIntro.titulo ?? ''" centered class="mb-12" />
                <div class="grid gap-6 md:grid-cols-3">
                    <div
                        v-for="(item, i) in serviciosIntro.datos_extra?.items ?? []"
                        :key="i"
                        class="card p-6 transition hover:shadow-soft"
                    >
                        <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-brand-100 text-brand-600">
                            <span class="text-lg font-bold">{{ i + 1 }}</span>
                        </div>
                        <h3 class="mb-2 font-semibold text-brand-950">{{ item.titulo[loc()] ?? item.titulo.es }}</h3>
                        <p class="text-sm leading-relaxed text-slate-500">{{ item.contenido[loc()] ?? item.contenido.es }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Urgencias -->
        <section v-if="urgencias" class="bg-gradient-to-r from-red-600 to-red-700 py-14 text-white">
            <div class="container-public flex flex-col items-center gap-6 text-center md:flex-row md:justify-between md:text-left">
                <div>
                    <h2 class="text-2xl font-bold md:text-3xl">{{ urgencias.titulo }}</h2>
                    <p class="mt-2 text-red-100">{{ t('cta.emergency_24h') }}</p>
                </div>
                <a
                    v-if="contacto.telefono_urgencias"
                    :href="telHref(contacto.telefono_urgencias)"
                    class="inline-flex items-center gap-2 rounded-full bg-white px-8 py-3.5 text-lg font-bold text-red-700 shadow-lg transition hover:bg-red-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    {{ contacto.telefono_urgencias }}
                </a>
            </div>
        </section>

        <!-- Sobre nosotros -->
        <section v-if="sobreNosotros" class="py-20">
            <div class="container-public">
                <div class="mx-auto max-w-3xl text-center">
                    <SectionHeading :title="sobreNosotros.titulo ?? ''" :subtitle="t('home.about')" centered class="mb-8" />
                    <p class="text-lg leading-relaxed text-slate-600">{{ sobreNosotros.contenido }}</p>
                </div>
            </div>
        </section>

        <!-- Zona de trabajo -->
        <section v-if="zonaTrabajo" class="border-y border-slate-200 bg-white py-16">
            <div class="container-public text-center">
                <SectionHeading :title="zonaTrabajo.titulo ?? ''" :subtitle="t('home.service_area')" centered class="mb-8" />
                <div class="flex flex-wrap justify-center gap-2">
                    <span
                        v-for="(ciudad, i) in zonaTrabajo.datos_extra?.ciudades ?? []"
                        :key="i"
                        class="rounded-full bg-slate-50 px-4 py-2 text-sm font-medium text-slate-700 ring-1 ring-slate-200"
                    >
                        {{ ciudad[loc()] ?? ciudad.es }}
                    </span>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section class="py-20">
            <div class="container-public">
                <div class="mx-auto max-w-3xl">
                    <SectionHeading :title="faqTitulo ?? t('home.faq')" centered class="mb-10" />
                    <FaqAccordion :items="faqs.map(f => ({ pregunta: f.pregunta, respuesta: f.respuesta }))" />
                </div>
            </div>
        </section>

        <!-- CTA final -->
        <section class="bg-brand-950 py-16 text-white">
            <div class="container-public text-center">
                <h2 class="text-3xl font-bold">{{ t('cta.contact_us') }}</h2>
                <p class="mx-auto mt-3 max-w-lg text-brand-200">{{ t('cta.free_quote') }}</p>
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <Link :href="urlQuote(locale)" class="btn-primary btn-on-dark">
                        {{ t('cta.request_quote') }}
                    </Link>
                    <Link :href="urlContact(locale)" class="btn-secondary">
                        {{ t('nav.contact') }}
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
