<script setup lang="ts">
import type { InertiaForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const props = defineProps<{
    form: InertiaForm<{
        nombre: string;
        email: string;
        telefono: string;
        servicio_id: string | number;
        servicio_detalle: string;
        zona: string;
        mensaje: string;
        recaptcha_token: string;
    }>;
    servicioOpciones?: string[];
    servicios?: Array<{ id: number; titulo: string }>;
    ciudades: Array<{ es: string; en: string }>;
    zoneOtherValue: string;
    locale: string;
    flashSuccess?: string;
    recaptchaEnabled: boolean;
    compact?: boolean;
}>();

defineEmits<{
    submit: [];
}>();

const fieldClass = computed(() => (props.compact ? 'input-public-compact' : 'input-public'));

function cityLabel(c: { es: string; en: string }, locale: string) {
    return locale === 'en' ? c.en : c.es;
}
</script>

<template>
    <div>
        <div
            v-if="flashSuccess"
            class="mb-3 rounded-lg bg-green-50 p-3 text-sm font-medium text-green-800 ring-1 ring-green-200"
            :class="compact ? '' : 'mb-4 rounded-xl p-4'"
        >
            {{ flashSuccess }}
        </div>

        <form
            class="card"
            :class="compact ? 'space-y-2.5 p-4 shadow-lg ring-brand-900/5' : 'space-y-4 p-5 md:p-6'"
            @submit.prevent="$emit('submit')"
        >
            <div :class="compact ? 'pb-1' : 'border-b border-slate-100 pb-4'">
                <h2 :class="compact ? 'text-base font-bold text-brand-950' : 'text-lg font-bold text-brand-950'">
                    {{ t('landing.form_title') }}
                </h2>
                <p v-if="!compact" class="mt-1 text-sm text-slate-600">{{ t('quote.subtitle') }}</p>
            </div>

            <template v-if="compact">
                <input
                    v-model="form.nombre"
                    required
                    autocomplete="name"
                    :class="fieldClass"
                    :placeholder="t('form.name')"
                    :aria-label="t('form.name')"
                />
                <div class="grid grid-cols-2 gap-2.5">
                    <input
                        v-model="form.telefono"
                        required
                        type="tel"
                        autocomplete="tel"
                        :class="fieldClass"
                        :placeholder="t('form.phone')"
                        :aria-label="t('form.phone')"
                    />
                    <input
                        v-model="form.email"
                        required
                        type="email"
                        autocomplete="email"
                        :class="fieldClass"
                        :placeholder="t('form.email')"
                        :aria-label="t('form.email')"
                    />
                </div>
                <select
                    v-if="servicioOpciones?.length"
                    v-model="form.servicio_detalle"
                    required
                    :class="fieldClass"
                    :aria-label="t('form.service')"
                >
                    <option value="">{{ t('form.service') }}</option>
                    <option v-for="opt in servicioOpciones" :key="opt" :value="opt">{{ opt }}</option>
                </select>
                <select
                    v-else
                    v-model="form.servicio_id"
                    required
                    :class="fieldClass"
                    :aria-label="t('form.service')"
                >
                    <option value="">{{ t('form.service') }}</option>
                    <option v-for="s in servicios ?? []" :key="s.id" :value="s.id">{{ s.titulo }}</option>
                </select>
                <select v-model="form.zona" :class="fieldClass" :aria-label="t('form.zone')">
                    <option value="">{{ t('landing.zone_placeholder') }}</option>
                    <option v-for="(c, i) in ciudades" :key="i" :value="cityLabel(c, locale)">{{ cityLabel(c, locale) }}</option>
                    <option :value="zoneOtherValue">{{ t('form.zone_other') }}</option>
                </select>
            </template>

            <template v-else>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.name') }}</label>
                    <input v-model="form.nombre" required autocomplete="name" :class="fieldClass" />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.phone') }}</label>
                    <input v-model="form.telefono" required type="tel" autocomplete="tel" :class="fieldClass" />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.email') }}</label>
                    <input v-model="form.email" required type="email" autocomplete="email" :class="fieldClass" />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.service') }}</label>
                    <select
                        v-if="servicioOpciones?.length"
                        v-model="form.servicio_detalle"
                        required
                        :class="fieldClass"
                    >
                        <option value="">{{ t('form.select_service') }}</option>
                        <option v-for="opt in servicioOpciones" :key="opt" :value="opt">{{ opt }}</option>
                    </select>
                    <select v-else v-model="form.servicio_id" required :class="fieldClass">
                        <option value="">{{ t('form.select_service') }}</option>
                        <option v-for="s in servicios ?? []" :key="s.id" :value="s.id">{{ s.titulo }}</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.zone') }}</label>
                    <select v-model="form.zona" :class="fieldClass">
                        <option value="">{{ t('form.select') }}</option>
                        <option v-for="(c, i) in ciudades" :key="i" :value="cityLabel(c, locale)">{{ cityLabel(c, locale) }}</option>
                        <option :value="zoneOtherValue">{{ t('form.zone_other') }}</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">{{ t('form.describe_need') }}</label>
                    <textarea v-model="form.mensaje" rows="3" :class="fieldClass" :placeholder="t('form.message_placeholder')" />
                </div>
            </template>

            <p v-if="form.errors.recaptcha_token" class="text-xs text-red-600">{{ form.errors.recaptcha_token }}</p>
            <button
                type="submit"
                :disabled="form.processing"
                class="btn-primary w-full disabled:opacity-50"
                :class="compact ? '!py-2.5 text-sm' : ''"
            >
                {{ t('landing.cta_quote_short') }}
            </button>
            <p v-if="recaptchaEnabled" class="text-[10px] leading-snug text-slate-400" :class="compact ? 'line-clamp-2' : 'text-xs'">
                {{ t('form.recaptcha_notice') }}
            </p>
        </form>
    </div>
</template>
