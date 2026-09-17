<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import ImagePlaceholder from '@/Components/Public/ImagePlaceholder.vue';
import ServiceIcon from '@/Components/Public/ServiceIcon.vue';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { urlService } from '@/lib/publicUrls';

const { t } = useI18n();
const page = usePage();
const locale = computed(() => page.props.locale as string);

defineProps<{
    servicios: Array<{
        slug: string;
        titulo: string;
        descripcion_corta: string;
        imagen_cabecera: string | null;
        icono: string | null;
    }>;
}>();
</script>

<template>
    <Head :title="t('nav.services')" />
    <PublicLayout>
        <section class="bg-brand-950 py-16 text-white">
            <div class="container-public">
                <h1 class="text-4xl font-bold">{{ t('nav.services') }}</h1>
                <p class="mt-2 text-brand-300">Urquiza Soluciones — Costa del Sol</p>
            </div>
        </section>

        <section class="py-16">
            <div class="container-public">
                <div class="grid gap-8 md:grid-cols-3">
                    <Link
                        v-for="servicio in servicios"
                        :key="servicio.slug"
                        :href="urlService(locale, servicio.slug)"
                        class="group card overflow-hidden transition hover:-translate-y-1 hover:shadow-soft"
                    >
                        <div class="relative overflow-hidden">
                            <ImagePlaceholder :src="servicio.imagen_cabecera" :alt="servicio.titulo" aspect="video" />
                            <div class="absolute left-4 top-4 rounded-xl bg-white/90 p-2.5 text-brand-600 shadow-sm backdrop-blur">
                                <ServiceIcon :icon="servicio.icono" class="h-5 w-5" />
                            </div>
                        </div>
                        <div class="p-6">
                            <h2 class="mb-2 text-xl font-bold text-brand-950 group-hover:text-brand-700">{{ servicio.titulo }}</h2>
                            <p class="text-sm leading-relaxed text-slate-500">{{ servicio.descripcion_corta }}</p>
                            <span class="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-brand-600">
                                {{ t('cta.view_service') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                            </span>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
