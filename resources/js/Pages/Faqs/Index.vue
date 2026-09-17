<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useFaqStore } from '@/stores/admin';

const store = useFaqStore();
const search = ref('');

onMounted(() => store.fetchList());

async function onDelete(id: number) {
    if (!confirm('¿Eliminar FAQ?')) return;
    await store.remove(id);
    store.fetchList();
}
</script>

<template>
    <Head title="FAQ" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="text-xl font-semibold">FAQ</h2>
                <Link :href="route('admin.faqs.create')" class="rounded bg-gray-800 px-4 py-2 text-sm text-white">Nueva</Link>
            </div>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100"><tr><th class="px-4 py-2 text-left">Pregunta</th><th class="px-4 py-2">Servicio</th><th class="px-4 py-2">Acciones</th></tr></thead>
                        <tbody>
                            <tr v-for="item in store.data" :key="item.id" class="border-b">
                                <td class="px-4 py-2">{{ item.pregunta }}</td>
                                <td class="px-4 py-2 text-center">{{ item.servicio_titulo ?? '—' }}</td>
                                <td class="px-4 py-2">
                                    <Link :href="route('admin.faqs.edit', item.id)" class="text-blue-600">Editar</Link>
                                    <button class="ml-3 text-red-600" @click="onDelete(item.id)">Eliminar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
