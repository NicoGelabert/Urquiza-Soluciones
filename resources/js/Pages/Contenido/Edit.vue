<script setup lang="ts">
import TranslatableInput from '@/Components/TranslatableInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useContenidoStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const props = defineProps<{ id: number }>();
const store = useContenidoStore();
const form = ref<any>(null);
const datosExtraJson = ref('');

onMounted(async () => {
    const { data } = await store.fetchOne(props.id);
    form.value = data.data;
    if (form.value.datos_extra) {
        datosExtraJson.value = JSON.stringify(form.value.datos_extra, null, 2);
    }
});

async function submit() {
    try {
        const payload = { ...form.value };
        if (datosExtraJson.value.trim()) {
            payload.datos_extra = JSON.parse(datosExtraJson.value);
        }
        await store.update(payload);
        router.visit(route('admin.contenido.index'));
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Editar contenido" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Editar: {{ form?.clave }}</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <form v-if="form" class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg" @submit.prevent="submit">
                    <p class="text-sm text-gray-500">Clave: <code>{{ form.clave }}</code></p>
                    <TranslatableInput v-model="form.titulo" label="Título" />
                    <TranslatableInput v-model="form.contenido" label="Contenido" textarea />
                    <div v-if="form.datos_extra !== undefined">
                        <label class="text-sm font-medium">Datos extra (JSON)</label>
                        <textarea v-model="datosExtraJson" rows="10" class="mt-1 w-full rounded border px-3 py-2 font-mono text-xs" />
                    </div>
                    <PrimaryButton type="submit">Guardar</PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
