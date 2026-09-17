<script setup lang="ts">
import ServicioForm from './ServicioForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useServicioStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const props = defineProps<{ id: number }>();
const store = useServicioStore();
const form = ref<any>(null);

onMounted(async () => {
    const { data } = await store.fetchOne(props.id);
    form.value = { ...data.data, imagen_cabecera: null, icono: data.data.icono ?? '' };
});

async function submit() {
    try {
        await store.update(form.value);
        router.visit(route('admin.servicios.index'));
    } catch (error: any) {
        alert(getApiErrorMessage(error, 'No se pudo actualizar el servicio.'));
    }
}
</script>

<template>
    <Head title="Editar servicio" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold text-gray-800">Editar servicio</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div v-if="form" class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <ServicioForm v-model="form" @submit="submit" />
                </div>
                <div v-else class="text-center text-gray-500">Cargando...</div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
