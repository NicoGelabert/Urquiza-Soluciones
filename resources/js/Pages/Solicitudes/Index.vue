<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useSolicitudStore } from '@/stores/admin';

const store = useSolicitudStore();
const estado = ref('');
const tipo = ref('');

onMounted(() => load());

function load() {
    store.fetchList({ estado: estado.value || undefined, tipo: tipo.value || undefined });
}

const estados: Record<string, string> = {
    pendiente: 'Pendiente',
    contestado: 'Contestado',
    cancelado: 'Cancelado',
};
</script>

<template>
    <Head title="Solicitudes" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Solicitudes</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="mb-4 flex gap-4">
                    <select v-model="tipo" class="rounded border px-3 py-2 text-sm" @change="load">
                        <option value="">Todos los tipos</option>
                        <option value="contacto">Contacto</option>
                        <option value="presupuesto">Presupuesto</option>
                    </select>
                    <select v-model="estado" class="rounded border px-3 py-2 text-sm" @change="load">
                        <option value="">Todos los estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="contestado">Contestado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in store.data" :key="item.id" class="border-b">
                                <td class="px-4 py-2">{{ item.created_at }}</td>
                                <td class="px-4 py-2">{{ item.nombre }}</td>
                                <td class="px-4 py-2 text-center capitalize">{{ item.tipo }}</td>
                                <td class="px-4 py-2 text-center">{{ estados[item.estado] ?? item.estado }}</td>
                                <td class="px-4 py-2">
                                    <Link :href="route('admin.solicitudes.show', { solicitud: item.id })" class="text-blue-600">Ver</Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
