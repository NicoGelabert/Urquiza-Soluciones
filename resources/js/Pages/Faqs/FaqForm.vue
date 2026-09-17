<script setup lang="ts">
import TranslatableInput from '@/Components/TranslatableInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const form = defineModel<any>({ required: true });
defineEmits<{ submit: [] }>();

const servicios = ref<any[]>([]);

onMounted(async () => {
    const { data } = await axios.get('/api/servicios', { params: { per_page: 100 } });
    servicios.value = data.data;
});
</script>

<template>
    <form class="space-y-4" @submit.prevent="$emit('submit')">
        <div>
            <label class="text-sm font-medium">Servicio (opcional)</label>
            <select v-model="form.servicio_id" class="mt-1 w-full rounded border px-3 py-2 text-sm">
                <option :value="null">Global</option>
                <option v-for="s in servicios" :key="s.id" :value="s.id">{{ s.titulo }}</option>
            </select>
        </div>
        <TranslatableInput v-model="form.pregunta" label="Pregunta" />
        <TranslatableInput v-model="form.respuesta" label="Respuesta" textarea />
        <div class="grid grid-cols-2 gap-4">
            <div><label class="text-sm">Orden</label><input v-model.number="form.orden" type="number" class="mt-1 w-full rounded border px-3 py-2 text-sm" /></div>
            <div class="flex items-end"><label class="flex gap-2 text-sm"><input v-model="form.activo" type="checkbox" /> Activo</label></div>
        </div>
        <PrimaryButton type="submit">Guardar</PrimaryButton>
    </form>
</template>
