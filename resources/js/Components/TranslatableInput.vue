<script setup lang="ts">
const props = defineProps<{
    label: string;
    modelValue: { es?: string; en?: string } | null | undefined;
    textarea?: boolean;
}>();

const emit = defineEmits<{ 'update:modelValue': [value: { es: string; en: string }] }>();

function update(lang: 'es' | 'en', value: string) {
    emit('update:modelValue', {
        es: lang === 'es' ? value : (props.modelValue?.es ?? ''),
        en: lang === 'en' ? value : (props.modelValue?.en ?? ''),
    });
}
</script>

<template>
    <div class="space-y-2">
        <label class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <div class="grid gap-3 md:grid-cols-2">
            <div>
                <span class="mb-1 block text-xs text-gray-500">ES</span>
                <textarea
                    v-if="textarea"
                    :value="modelValue?.es ?? ''"
                    rows="4"
                    class="w-full rounded border px-3 py-2 text-sm"
                    @input="update('es', ($event.target as HTMLTextAreaElement).value)"
                />
                <input
                    v-else
                    :value="modelValue?.es ?? ''"
                    type="text"
                    class="w-full rounded border px-3 py-2 text-sm"
                    @input="update('es', ($event.target as HTMLInputElement).value)"
                />
            </div>
            <div>
                <span class="mb-1 block text-xs text-gray-500">EN</span>
                <textarea
                    v-if="textarea"
                    :value="modelValue?.en ?? ''"
                    rows="4"
                    class="w-full rounded border px-3 py-2 text-sm"
                    @input="update('en', ($event.target as HTMLTextAreaElement).value)"
                />
                <input
                    v-else
                    :value="modelValue?.en ?? ''"
                    type="text"
                    class="w-full rounded border px-3 py-2 text-sm"
                    @input="update('en', ($event.target as HTMLInputElement).value)"
                />
            </div>
        </div>
    </div>
</template>
