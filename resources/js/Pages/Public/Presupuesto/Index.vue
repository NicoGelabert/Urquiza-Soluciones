<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { executeRecaptcha } from '@/lib/recaptcha';

const { t } = useI18n();

defineProps<{
    servicios: Array<{ id: number; titulo: string }>;
    ciudades: Array<{ es: string; en: string }>;
}>();

const page = usePage();
const locale = computed(() => page.props.locale as string);
const flashSuccess = computed(() => (page.props.flash as { success?: string } | undefined)?.success);
const recaptcha = computed(() => page.props.recaptcha as { site_key: string | null; enabled: boolean });

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    servicio_id: '' as string | number,
    zona: '',
    mensaje: '',
    recaptcha_token: '',
});

const presupuestoRoute = computed(() => (locale.value === 'en' ? 'en.presupuesto.store' : 'presupuesto.store'));

function loc() {
    return locale.value as 'es' | 'en';
}

async function submit() {
    if (recaptcha.value.enabled && recaptcha.value.site_key) {
        form.recaptcha_token = await executeRecaptcha(recaptcha.value.site_key, 'quote');
    }

    form.post(route(presupuestoRoute.value), { preserveScroll: true, onSuccess: () => form.reset() });
}
</script>

<template>
    <Head :title="t('nav.quote')" />
    <PublicLayout>
        <section class="bg-brand-950 py-16 text-white">
            <div class="container-public">
                <h1 class="text-4xl font-bold">{{ t('nav.quote') }}</h1>
                <p class="mt-3 max-w-2xl text-lg text-brand-200">{{ t('quote.subtitle') }}</p>
            </div>
        </section>

        <section class="py-16">
            <div class="container-public">
                <div class="mx-auto max-w-xl">
                    <div v-if="flashSuccess" class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-800 ring-1 ring-green-200">
                        {{ flashSuccess }}
                    </div>

                    <form class="card space-y-5 p-6 md:p-8" @submit.prevent="submit">
                        <div>
                            <label class="text-sm font-medium text-slate-700">{{ t('form.name') }}</label>
                            <input v-model="form.nombre" required class="input-public" />
                        </div>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.email') }}</label>
                                <input v-model="form.email" type="email" required class="input-public" />
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.phone') }}</label>
                                <input v-model="form.telefono" class="input-public" />
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">{{ t('form.service') }}</label>
                            <select v-model="form.servicio_id" required class="input-public">
                                <option value="">{{ t('form.select_service') }}</option>
                                <option v-for="s in servicios" :key="s.id" :value="s.id">{{ s.titulo }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">{{ t('form.zone') }}</label>
                            <select v-model="form.zona" class="input-public">
                                <option value="">{{ t('form.select') }}</option>
                                <option v-for="(c, i) in ciudades" :key="i" :value="c[loc()] ?? c.es">{{ c[loc()] ?? c.es }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">{{ t('form.describe_need') }}</label>
                            <textarea v-model="form.mensaje" required rows="5" class="input-public" :placeholder="t('form.message_placeholder')" />
                        </div>
                        <p v-if="form.errors.recaptcha_token" class="text-sm text-red-600">{{ form.errors.recaptcha_token }}</p>
                        <button type="submit" :disabled="form.processing" class="btn-primary w-full disabled:opacity-50">
                            {{ t('cta.request_quote') }}
                        </button>
                        <p v-if="recaptcha.enabled" class="text-xs text-slate-400">
                            {{ t('form.recaptcha_notice') }}
                        </p>
                    </form>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
