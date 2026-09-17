<script setup lang="ts">
import ServicioForm from './ServicioForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useServicioStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const store = useServicioStore();
const form = ref({
    slug: '',
    slug_en: '',
    icono: '',
    orden: 0,
    activo: true,
    titulo: { es: '', en: '' },
    hero_subtitulo: { es: '', en: '' },
    descripcion_corta: { es: '', en: '' },
    descripcion_larga: { es: '', en: '' },
    meta_title: { es: '', en: '' },
    meta_description: { es: '', en: '' },
    items: [] as any[],
    imagen_cabecera: null as File | null,
});

async function submit() {
    try {
        await store.create(form.value);
        router.visit(route('admin.servicios.index'));
    } catch (error: any) {
        alert(getApiErrorMessage(error, 'No se pudo crear el servicio.'));
    }
}
</script>

<template>
    <Head title="Nuevo servicio" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold text-gray-800">Nuevo servicio</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <ServicioForm v-model="form" @submit="submit" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
