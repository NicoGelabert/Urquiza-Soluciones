<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useServicioStore } from '@/stores/admin';

const store = useServicioStore();
const search = ref('');

onMounted(() => store.fetchList());

function onSearch() {
    store.fetchList({ search: search.value });
}

async function onDelete(id: number) {
    if (!confirm('¿Eliminar este servicio?')) return;
    await store.remove(id);
    store.fetchList({ search: search.value });
}
</script>

<template>
    <Head title="Servicios" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Servicios</h2>
                <Link :href="route('admin.servicios.create')" class="rounded bg-gray-800 px-4 py-2 text-sm text-white">Nuevo</Link>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                    <input v-model="search" type="text" placeholder="Buscar..." class="mb-4 w-64 rounded border px-3 py-2 text-sm" @input="onSearch" />
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Título</th>
                                <th class="px-4 py-2 text-left">Slug</th>
                                <th class="px-4 py-2">Orden</th>
                                <th class="px-4 py-2">Activo</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="store.loading"><td colspan="5" class="py-4 text-center">Cargando...</td></tr>
                            <tr v-for="item in store.data" :key="item.id" class="border-b">
                                <td class="px-4 py-2">{{ item.titulo }}</td>
                                <td class="px-4 py-2">{{ item.slug }}</td>
                                <td class="px-4 py-2 text-center">{{ item.orden }}</td>
                                <td class="px-4 py-2 text-center">{{ item.activo ? 'Sí' : 'No' }}</td>
                                <td class="px-4 py-2">
                                    <Link :href="route('admin.servicios.edit', item.id)" class="text-blue-600 hover:underline">Editar</Link>
                                    <button class="ml-3 text-red-600 hover:underline" @click="onDelete(item.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
