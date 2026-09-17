<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { useContenidoStore } from '@/stores/admin';

const store = useContenidoStore();
onMounted(() => store.fetchList({ per_page: 50 }));
</script>

<template>
    <Head title="Contenido" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Contenido del sitio</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <div class="divide-y rounded-lg bg-white shadow-sm">
                    <div v-for="item in store.data" :key="item.id" class="flex items-center justify-between p-4">
                        <div>
                            <p class="font-medium">{{ item.clave }}</p>
                            <p class="text-sm text-gray-500">{{ item.titulo?.es }}</p>
                        </div>
                        <Link :href="route('admin.contenido.edit', item.id)" class="text-blue-600 text-sm">Editar</Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
