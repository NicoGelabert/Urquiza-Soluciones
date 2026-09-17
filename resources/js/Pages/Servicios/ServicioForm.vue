<script setup lang="ts">
import TranslatableInput from '@/Components/TranslatableInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ServiceIcon from '@/Components/Public/ServiceIcon.vue';
import { serviceIconOptions } from '@/lib/serviceIcons';

const form = defineModel<any>({ required: true });
defineEmits<{ submit: [] }>();

function addItem() {
    form.value.items.push({ titulo: { es: '', en: '' }, descripcion: { es: '', en: '' }, orden: form.value.items.length + 1 });
}

function removeItem(index: number) {
    form.value.items.splice(index, 1);
}

function onFileChange(event: Event) {
    const file = (event.target as HTMLInputElement).files?.[0] ?? null;
    form.value.imagen_cabecera = file;
}
</script>

<template>
    <form class="space-y-6" @submit.prevent="$emit('submit')">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="text-sm font-medium">Slug (ES)</label>
                <input v-model="form.slug" type="text" class="mt-1 w-full rounded border px-3 py-2 text-sm" required />
            </div>
            <div>
                <label class="text-sm font-medium">Slug (EN)</label>
                <input v-model="form.slug_en" type="text" class="mt-1 w-full rounded border px-3 py-2 text-sm" required />
            </div>
        </div>

        <TranslatableInput v-model="form.titulo" label="Título" />
        <TranslatableInput v-model="form.hero_subtitulo" label="Subtítulo hero" />
        <TranslatableInput v-model="form.descripcion_corta" label="Descripción corta" textarea />
        <TranslatableInput v-model="form.descripcion_larga" label="Descripción larga" textarea />

        <div class="grid gap-4 md:grid-cols-3">
            <div>
                <label class="text-sm font-medium">Icono</label>
                <div class="mt-1 flex items-center gap-3">
                    <select v-model="form.icono" class="w-full rounded border px-3 py-2 text-sm">
                        <option v-for="opt in serviceIconOptions" :key="opt.value || 'default'" :value="opt.value">
                            {{ opt.label }}
                        </option>
                    </select>
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                        <ServiceIcon :icon="form.icono || null" class="h-5 w-5" />
                    </span>
                </div>
            </div>
            <div>
                <label class="text-sm font-medium">Orden</label>
                <input v-model.number="form.orden" type="number" min="0" class="mt-1 w-full rounded border px-3 py-2 text-sm" />
            </div>
            <div class="flex items-end">
                <label class="flex items-center gap-2 text-sm">
                    <input v-model="form.activo" type="checkbox" /> Activo
                </label>
            </div>
        </div>

        <div>
            <label class="text-sm font-medium">Imagen cabecera</label>
            <input type="file" accept="image/*" class="mt-1 block text-sm" @change="onFileChange" />
            <img v-if="form.imagen_cabecera_path" :src="form.imagen_cabecera_path" class="mt-2 h-24 rounded object-cover" alt="" />
        </div>

        <div>
            <div class="mb-2 flex items-center justify-between">
                <h3 class="font-medium">Sub-servicios</h3>
                <button type="button" class="text-sm text-blue-600" @click="addItem">+ Añadir</button>
            </div>
            <div v-for="(item, index) in form.items" :key="index" class="mb-4 rounded border p-4">
                <TranslatableInput v-model="item.titulo" label="Título" />
                <button type="button" class="mt-2 text-sm text-red-600" @click="removeItem(index)">Eliminar</button>
            </div>
        </div>

        <PrimaryButton type="submit">Guardar</PrimaryButton>
    </form>
</template>
