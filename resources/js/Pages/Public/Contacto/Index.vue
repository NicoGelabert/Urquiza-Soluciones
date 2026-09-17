<script setup lang="ts">
import PublicLayout from '@/Layouts/PublicLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';
import { telHref } from '@/lib/phone';
import { executeRecaptcha } from '@/lib/recaptcha';

const { t } = useI18n();

defineProps<{
    intro: { titulo: string | null; contenido: string | null };
    ciudades: Array<{ es: string; en: string }>;
}>();

const page = usePage();
const locale = computed(() => page.props.locale as string);
const flashSuccess = computed(() => (page.props.flash as { success?: string } | undefined)?.success);
const site = computed(() => page.props.site as { telefono?: string; email?: string; whatsapp?: string });
const recaptcha = computed(() => page.props.recaptcha as { site_key: string | null; enabled: boolean });

const form = useForm({
    nombre: '',
    email: '',
    telefono: '',
    zona: '',
    mensaje: '',
    recaptcha_token: '',
});

const contactRoute = computed(() => (locale.value === 'en' ? 'en.contacto.store' : 'contacto.store'));

function loc() {
    return locale.value as 'es' | 'en';
}

async function submit() {
    if (recaptcha.value.enabled && recaptcha.value.site_key) {
        form.recaptcha_token = await executeRecaptcha(recaptcha.value.site_key, 'contact');
    }

    form.post(route(contactRoute.value), { preserveScroll: true, onSuccess: () => form.reset() });
}
</script>

<template>
    <Head :title="t('nav.contact')" />
    <PublicLayout>
        <section class="bg-brand-950 py-16 text-white">
            <div class="container-public">
                <h1 class="text-4xl font-bold">{{ intro.titulo ?? t('nav.contact') }}</h1>
                <p v-if="intro.contenido" class="mt-3 max-w-2xl text-lg text-brand-200">{{ intro.contenido }}</p>
            </div>
        </section>

        <section class="py-16">
            <div class="container-public">
                <div class="mx-auto grid max-w-4xl gap-12 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <div class="card p-6">
                            <p class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-400">{{ t('footer.contact') }}</p>
                            <ul class="space-y-4 text-sm">
                                <li v-if="site.telefono" class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                    </span>
                                    <a :href="telHref(site.telefono)" class="font-medium text-slate-700 hover:text-brand-600">{{ site.telefono }}</a>
                                </li>
                                <li v-if="site.email" class="flex items-center gap-3">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                    </span>
                                    <a :href="`mailto:${site.email}`" class="font-medium text-slate-700 hover:text-brand-600">{{ site.email }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="lg:col-span-3">
                        <div v-if="flashSuccess" class="mb-6 rounded-xl bg-green-50 p-4 text-sm font-medium text-green-800 ring-1 ring-green-200">
                            {{ flashSuccess }}
                        </div>

                        <form class="card space-y-5 p-6 md:p-8" @submit.prevent="submit">
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.name') }}</label>
                                <input v-model="form.nombre" required class="input-public" />
                                <p v-if="form.errors.nombre" class="mt-1 text-sm text-red-600">{{ form.errors.nombre }}</p>
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
                                <label class="text-sm font-medium text-slate-700">{{ t('form.zone') }}</label>
                                <select v-model="form.zona" class="input-public">
                                    <option value="">{{ t('form.select') }}</option>
                                    <option v-for="(c, i) in ciudades" :key="i" :value="c[loc()] ?? c.es">{{ c[loc()] ?? c.es }}</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-700">{{ t('form.message') }}</label>
                                <textarea v-model="form.mensaje" required rows="5" class="input-public" />
                            </div>
                            <p v-if="form.errors.recaptcha_token" class="text-sm text-red-600">{{ form.errors.recaptcha_token }}</p>
                            <button type="submit" :disabled="form.processing" class="btn-primary w-full sm:w-auto disabled:opacity-50">
                                {{ t('form.send_message') }}
                            </button>
                            <p v-if="recaptcha.enabled" class="text-xs text-slate-400">
                                {{ t('form.recaptcha_notice') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
