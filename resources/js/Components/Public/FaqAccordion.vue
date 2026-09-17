<script setup lang="ts">
defineProps<{
    items: Array<{ pregunta: string; respuesta: string }>;
}>();
</script>

<template>
    <div class="space-y-3">
        <details
            v-for="(faq, i) in items"
            :key="i"
            class="group card overflow-hidden"
        >
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 p-5 font-medium text-brand-950 marker:content-none [&::-webkit-details-marker]:hidden">
                <span>{{ faq.pregunta }}</span>
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-600 transition group-open:rotate-45">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
            </summary>
            <div class="border-t border-slate-100 px-5 pb-5 pt-3 text-sm leading-relaxed text-slate-600">
                {{ faq.respuesta }}
            </div>
        </details>
    </div>
</template>
