<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    pagina: { slug: string; titulo: string; contenido: string };
}>();
</script>

<template>
    <Head :title="pagina.titulo" />
    <PublicLayout>
        <section class="bg-slate-50 py-12">
            <div class="container-public">
                <h1 class="text-3xl font-bold text-brand-950">{{ pagina.titulo }}</h1>
            </div>
        </section>
        <section class="py-12">
            <div class="container-public">
                <div class="legal-content mx-auto max-w-3xl card p-8 md:p-10" v-html="pagina.contenido" />
            </div>
        </section>
    </PublicLayout>
</template>
