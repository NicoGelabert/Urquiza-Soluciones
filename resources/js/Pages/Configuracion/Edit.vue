<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useConfiguracionStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const store = useConfiguracionStore();
const saved = ref(false);

onMounted(() => store.fetch());

async function submit() {
    try {
        await store.update(store.data);
        saved.value = true;
        setTimeout(() => (saved.value = false), 3000);
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Configuración" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Configuración de contacto</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-xl sm:px-6 lg:px-8">
                <form class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg" @submit.prevent="submit">
                    <div><label class="text-sm">Teléfono</label><input v-model="store.data.telefono" class="mt-1 w-full rounded border px-3 py-2 text-sm" /></div>
                    <div><label class="text-sm">WhatsApp</label><input v-model="store.data.whatsapp" class="mt-1 w-full rounded border px-3 py-2 text-sm" /></div>
                    <div><label class="text-sm">Instagram (URL)</label><input v-model="store.data.instagram" class="mt-1 w-full rounded border px-3 py-2 text-sm" placeholder="https://instagram.com/..." /></div>
                    <div><label class="text-sm">Email</label><input v-model="store.data.email" type="email" class="mt-1 w-full rounded border px-3 py-2 text-sm" /></div>
                    <div><label class="text-sm">Teléfono urgencias</label><input v-model="store.data.telefono_urgencias" class="mt-1 w-full rounded border px-3 py-2 text-sm" /></div>
                    <p v-if="saved" class="text-sm text-green-600">Guardado correctamente.</p>
                    <PrimaryButton type="submit">Guardar</PrimaryButton>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
