<script setup lang="ts">
import TranslatableInput from '@/Components/TranslatableInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useLegalStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const props = defineProps<{ id: number }>();
const store = useLegalStore();
const form = ref<any>(null);

onMounted(async () => {
    const { data } = await store.fetchOne(props.id);
    form.value = data.data;
});

async function submit() {
    try {
        await store.update(form.value);
        router.visit(route('admin.legal.index'));
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Editar legal" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Editar: {{ form?.slug }}</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                <form v-if="form" class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg" @submit.prevent="submit">
                    <TranslatableInput v-model="form.titulo" label="Título" />
                    <TranslatableInput v-model="form.contenido" label="Contenido (HTML)" textarea />
                    <PrimaryButton type="submit">Guardar</PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
