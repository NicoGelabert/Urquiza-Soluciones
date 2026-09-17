<script setup lang="ts">
import FaqForm from './FaqForm.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useFaqStore } from '@/stores/admin';
import { getApiErrorMessage } from '@/lib/apiError';

const props = defineProps<{ id: number }>();
const store = useFaqStore();
const form = ref<any>(null);

onMounted(async () => {
    const { data } = await store.fetchOne(props.id);
    form.value = data.data;
});

async function submit() {
    try {
        await store.update(form.value);
        router.visit(route('admin.faqs.index'));
    } catch (e: any) {
        alert(getApiErrorMessage(e, 'Error al guardar.'));
    }
}
</script>

<template>
    <Head title="Editar FAQ" />
    <AuthenticatedLayout>
        <template #header><h2 class="text-xl font-semibold">Editar FAQ</h2></template>
        <div class="py-12"><div class="mx-auto max-w-3xl sm:px-6 lg:px-8"><div v-if="form" class="bg-white p-6 shadow-sm sm:rounded-lg"><FaqForm v-model="form" @submit="submit" /></div></div></div>
    </AuthenticatedLayout>
</template>
