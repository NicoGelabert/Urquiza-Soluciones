<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import FaqAccordion from '@/Components/Public/FaqAccordion.vue';
import ImagePlaceholder from '@/Components/Public/ImagePlaceholder.vue';
import SectionHeading from '@/Components/Public/SectionHeading.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { urlQuote } from '@/lib/publicUrls';

const { t } = useI18n();
const page = usePage();
const locale = computed(() => page.props.locale as string);

defineProps<{
    servicio: {
        slug: string;
        titulo: string;
        hero_subtitulo: string | null;
        descripcion_corta: string;
        descripcion_larga: string;
        imagen_cabecera: string | null;
        icono: string | null;
        items: Array<{ titulo: string; descripcion: string | null }>;
        imagenes: string[];
        faqs: Array<{ pregunta: string; respuesta: string }>;
    };
    contacto: { telefono?: string; whatsapp?: string; telefono_urgencias?: string };
}>();
</script>

<template>
    <Head :title="servicio.titulo" />
    <PublicLayout>
        <section class="relative overflow-hidden bg-brand-950 py-20 text-white">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_var(--tw-gradient-stops))] from-brand-700/40 via-transparent to-transparent" />
            <div class="container-public relative">
                <p v-if="servicio.hero_subtitulo" class="mb-2 text-sm font-semibold uppercase tracking-widest text-brand-300">
                    {{ servicio.hero_subtitulo }}
                </p>
                <h1 class="mb-4 text-4xl font-bold tracking-tight sm:text-5xl">{{ servicio.titulo }}</h1>
                <p class="max-w-2xl text-lg leading-relaxed text-slate-300">{{ servicio.descripcion_corta }}</p>
            </div>
        </section>

        <section class="py-16">
            <div class="container-public">
                <div class="grid items-start gap-12 lg:grid-cols-2">
                    <div>
                        <SectionHeading :title="t('service.what_we_offer')" class="mb-6" />
                        <p class="mb-8 leading-relaxed text-slate-600">{{ servicio.descripcion_larga }}</p>
                        <ul class="space-y-3">
                            <li
                                v-for="(item, i) in servicio.items"
                                :key="i"
                                class="flex items-start gap-3 rounded-xl bg-slate-50 p-4 text-sm text-slate-700"
                            >
                                <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                </span>
                                {{ item.titulo }}
                            </li>
                        </ul>
                    </div>
                    <div class="overflow-hidden rounded-2xl shadow-card ring-1 ring-slate-200/80">
                        <ImagePlaceholder :src="servicio.imagen_cabecera" :alt="servicio.titulo" aspect="square" />
                    </div>
                </div>
            </div>
        </section>

        <section v-if="servicio.faqs.length" class="bg-white py-16">
            <div class="container-public">
                <div class="mx-auto max-w-3xl">
                    <SectionHeading :title="t('service.faq')" centered class="mb-10" />
                    <FaqAccordion :items="servicio.faqs" />
                </div>
            </div>
        </section>

        <section class="border-t border-slate-200 bg-slate-50 py-16">
            <div class="container-public text-center">
                <h2 class="text-2xl font-bold text-brand-950">{{ t('cta.request_quote') }}</h2>
                <p class="mt-2 text-slate-500">{{ t('cta.free_quote') }}</p>
                <Link :href="urlQuote(locale)" class="btn-primary mt-6">
                    {{ t('cta.request_quote') }}
                </Link>
            </div>
        </section>
    </PublicLayout>
</template>
