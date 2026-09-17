<script setup lang="ts">
import { computed } from 'vue';
import { resolveIconPath } from '@/lib/serviceIcons';

const props = defineProps<{
    icon?: string | null;
}>();

const path = computed(() => resolveIconPath(props.icon));
</script>

<template>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" v-bind="$attrs">
        <path stroke-linecap="round" stroke-linejoin="round" :d="path" />
    </svg>
</template>
