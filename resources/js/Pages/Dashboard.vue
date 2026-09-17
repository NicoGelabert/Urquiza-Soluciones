<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    stats: {
        solicitudes_pendientes: number;
        servicios_activos: number;
    };
    contacto: {
        telefono?: string;
        email?: string;
    };
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Panel de administración
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Solicitudes pendientes</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ stats.solicitudes_pendientes }}</p>
                    </div>
                    <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500">Servicios activos</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900">{{ stats.servicios_activos }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
