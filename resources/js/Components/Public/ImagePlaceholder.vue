<script setup lang="ts">
defineProps<{
    src?: string | null;
    alt?: string;
    label?: string;
    aspect?: 'video' | 'square' | 'hero';
}>();
</script>

<template>
    <div
        class="overflow-hidden"
        :class="{
            'aspect-video': aspect === 'video' || !aspect,
            'aspect-square': aspect === 'square',
            'min-h-[220px] aspect-[4/3] lg:aspect-auto lg:min-h-[360px]': aspect === 'hero',
        }"
    >
        <img v-if="src" :src="src" :alt="alt ?? ''" class="h-full w-full object-cover" />
        <div v-else class="flex h-full flex-col items-center justify-center gap-3 p-8 text-white/40">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span v-if="label" class="text-sm font-medium">{{ label }}</span>
        </div>
    </div>
</template>
