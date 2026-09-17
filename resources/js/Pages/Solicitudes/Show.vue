<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useSolicitudStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const props = defineProps<{ id: number }>();
const store = useSolicitudStore();
const solicitud = ref<any>(null);
const form = ref({ estado: 'pendiente', notas_admin: '' });

onMounted(async () => {
    const { data } = await store.fetchOne(props.id);
    solicitud.value = data.data;
    form.value = { estado: data.data.estado, notas_admin: data.data.notas_admin ?? '' };
});

async function submit() {
    try {
        await store.update({ id: props.id, ...form.value });
        router.visit(route('admin.solicitudes.index'));
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Solicitud" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Solicitud #{{ id }}</h2></template>
        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                <div v-if="solicitud" class="space-y-6">
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <dl class="grid gap-3 text-sm md:grid-cols-2">
                            <div><dt class="text-gray-500">Nombre</dt><dd>{{ solicitud.nombre }}</dd></div>
                            <div><dt class="text-gray-500">Email</dt><dd>{{ solicitud.email }}</dd></div>
                            <div><dt class="text-gray-500">Teléfono</dt><dd>{{ solicitud.telefono ?? '—' }}</dd></div>
                            <div><dt class="text-gray-500">Tipo</dt><dd class="capitalize">{{ solicitud.tipo }}</dd></div>
                            <div><dt class="text-gray-500">Servicio</dt><dd>{{ solicitud.servicio_titulo ?? '—' }}</dd></div>
                            <div><dt class="text-gray-500">Zona</dt><dd>{{ solicitud.zona ?? '—' }}</dd></div>
                        </dl>
                        <p class="mt-4 text-sm"><span class="text-gray-500">Mensaje:</span><br />{{ solicitud.mensaje }}</p>
                    </div>
                    <form class="rounded-lg bg-white p-6 shadow-sm space-y-4" @submit.prevent="submit">
                        <div>
                            <label class="text-sm font-medium">Estado</label>
                            <select v-model="form.estado" class="mt-1 w-full rounded border px-3 py-2 text-sm">
                                <option value="pendiente">Pendiente</option>
                                <option value="contestado">Contestado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium">Notas internas</label>
                            <textarea v-model="form.notas_admin" rows="4" class="mt-1 w-full rounded border px-3 py-2 text-sm" />
                        </div>
                        <PrimaryButton type="submit">Actualizar</PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
