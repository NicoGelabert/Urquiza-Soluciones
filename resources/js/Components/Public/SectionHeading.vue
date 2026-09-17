<script setup lang="ts">
defineProps<{
    title: string;
    subtitle?: string | null;
    centered?: boolean;
}>();
</script>

<template>
    <div :class="centered ? 'text-center' : ''">
        <p v-if="subtitle" class="mb-2 text-sm font-semibold uppercase tracking-widest text-brand-600">{{ subtitle }}</p>
        <h2 class="text-3xl font-bold tracking-tight text-brand-950 sm:text-4xl">{{ title }}</h2>
        <div v-if="centered" class="mx-auto mt-4 h-1 w-12 rounded-full bg-brand-500" />
    </div>
</template>
