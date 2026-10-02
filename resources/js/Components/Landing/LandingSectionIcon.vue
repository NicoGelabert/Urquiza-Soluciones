<script setup lang="ts">
import { computed } from 'vue';
import { resolveLandingIconPath } from '@/lib/landingIcons';

const props = defineProps<{
    icon: string;
    size?: 'sm' | 'md';
}>();

const path = computed(() => resolveLandingIconPath(props.icon));

const boxClass = computed(() =>
    props.size === 'sm' ? 'h-10 w-10 rounded-xl' : 'h-12 w-12 rounded-2xl',
);
</script>

<template>
    <span
        class="inline-flex shrink-0 items-center justify-center bg-brand-100 text-brand-700"
        :class="boxClass"
        aria-hidden="true"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-1/2 w-1/2">
            <path :d="path" />
        </svg>
    </span>
</template>
