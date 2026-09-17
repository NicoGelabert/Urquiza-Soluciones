<script setup lang="ts">
import FaqForm from './FaqForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useFaqStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const store = useFaqStore();
const form = ref({ servicio_id: null, pregunta: { es: '', en: '' }, respuesta: { es: '', en: '' }, orden: 0, activo: true });

async function submit() {
    try {
        await store.create(form.value);
        router.visit(route('admin.faqs.index'));
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Nueva FAQ" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Nueva FAQ</h2></template>
        <div class="py-12"><div class="mx-auto max-w-3xl sm:px-6 lg:px-8"><div class="bg-white p-6 shadow-sm sm:rounded-lg"><FaqForm v-model="form" @submit="submit" /></div></div></div>
    </AuthenticatedLayout>
</template>
