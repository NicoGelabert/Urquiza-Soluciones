<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { telHref, whatsappHref } from '@/lib/phone';

defineProps<{
    homeUrl: string;
    switchLocaleUrl: string;
    localeLabel: string;
    navLinks: Array<{ href: string; label: string }>;
    whatsapp?: string;
    instagram?: string;
    telefonoUrgencias?: string;
    emergencyLabel: string;
    whatsappLabel: string;
    instagramLabel: string;
    closeLabel: string;
}>();

const open = defineModel<boolean>({ default: false });

function close() {
    open.value = false;
}

function instagramHref(url?: string): string | undefined {
    if (!url?.trim()) {
        return undefined;
    }

    const trimmed = url.trim();

    return /^https?:\/\//i.test(trimmed) ? trimmed : `https://${trimmed}`;
}
</script>

<template>
    <Teleport to="body">
        <Transition name="mobile-menu">
            <div
                v-if="open"
                class="mobile-menu-panel fixed inset-0 z-50 flex h-[100dvh] w-full flex-col bg-slate-50 md:hidden"
                role="dialog"
                aria-modal="true"
            >
                <div class="container-public flex h-full w-full flex-col">
                    <div class="flex h-16 w-full shrink-0 items-center justify-between">
                        <Link :href="homeUrl" @click="close">
                            <ApplicationLogo class="h-11 w-auto fill-current text-brand-950" />
                        </Link>
                        <button
                            type="button"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 transition hover:bg-slate-100 hover:text-brand-950"
                            :aria-label="closeLabel"
                            @click="close"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <nav class="flex flex-1 flex-col items-center justify-center gap-2 px-2">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="w-full rounded-2xl px-4 py-4 text-center text-2xl font-semibold tracking-tight text-slate-800 transition hover:bg-white hover:text-brand-700"
                            @click="close"
                        >
                            {{ link.label }}
                        </Link>

                        <a
                            v-if="telefonoUrgencias"
                            :href="telHref(telefonoUrgencias)"
                            class="mt-2 inline-flex items-center justify-center gap-2 rounded-2xl bg-red-600 px-6 py-4 text-lg font-semibold text-white transition hover:bg-red-700"
                            @click="close"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ emergencyLabel }}
                        </a>
                    </nav>

                    <div class="shrink-0 border-t border-slate-200 py-6">
                        <div class="flex items-center justify-center gap-3">
                            <a
                                v-if="whatsappHref(whatsapp)"
                                :href="whatsappHref(whatsapp)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-[#25D366] transition hover:border-slate-300 hover:bg-slate-200"
                                :aria-label="whatsappLabel"
                                @click="close"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <g id="WA_Logo">
                                        <path style="fill-rule:evenodd;clip-rule:evenodd;" d="M20.463,3.488C18.217,1.24,15.231,0.001,12.05,0    C5.495,0,0.16,5.334,0.157,11.892c-0.001,2.096,0.547,4.142,1.588,5.946L0.057,24l6.304-1.654    c1.737,0.948,3.693,1.447,5.683,1.448h0.005c6.554,0,11.89-5.335,11.893-11.893C23.944,8.724,22.708,5.735,20.463,3.488z     M12.05,21.785h-0.004c-1.774,0-3.513-0.477-5.031-1.378l-0.361-0.214l-3.741,0.981l0.999-3.648l-0.235-0.374    c-0.99-1.574-1.512-3.393-1.511-5.26c0.002-5.45,4.437-9.884,9.889-9.884c2.64,0,5.122,1.03,6.988,2.898    c1.866,1.869,2.893,4.352,2.892,6.993C21.932,17.351,17.498,21.785,12.05,21.785z M17.472,14.382    c-0.297-0.149-1.758-0.868-2.031-0.967c-0.272-0.099-0.47-0.149-0.669,0.148s-0.767,0.967-0.941,1.166    c-0.173,0.198-0.347,0.223-0.644,0.074c-0.297-0.149-1.255-0.462-2.39-1.475c-0.883-0.788-1.48-1.761-1.653-2.059    s-0.018-0.458,0.13-0.606c0.134-0.133,0.297-0.347,0.446-0.521C9.87,9.97,9.919,9.846,10.019,9.647    c0.099-0.198,0.05-0.372-0.025-0.521C9.919,8.978,9.325,7.515,9.078,6.92c-0.241-0.58-0.486-0.501-0.669-0.51    C8.236,6.401,8.038,6.4,7.839,6.4c-0.198,0-0.52,0.074-0.792,0.372c-0.272,0.298-1.04,1.017-1.04,2.479    c0,1.463,1.065,2.876,1.213,3.074c0.148,0.198,2.095,3.2,5.076,4.487c0.709,0.306,1.263,0.489,1.694,0.626    c0.712,0.226,1.36,0.194,1.872,0.118c0.571-0.085,1.758-0.719,2.006-1.413c0.248-0.694,0.248-1.29,0.173-1.413    C17.967,14.605,17.769,14.531,17.472,14.382z" />
                                    </g>
                                </svg>
                            </a>

                            <a
                                v-if="instagramHref(instagram)"
                                :href="instagramHref(instagram)"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 bg-slate-100 text-[#E1306C] transition hover:border-slate-300 hover:bg-slate-200"
                                :aria-label="instagramLabel"
                                @click="close"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                    <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4a5.8 5.8 0 0 1-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8A5.8 5.8 0 0 1 7.8 2m-.2 2A3.6 3.6 0 0 0 4 7.6v8.8C4 18.39 5.61 20 7.6 20h8.8a3.6 3.6 0 0 0 3.6-3.6V7.6C20 5.61 18.39 4 16.4 4H7.6m9.65 1.5a1.25 1.25 0 0 1 1.25 1.25A1.25 1.25 0 0 1 17.25 8 1.25 1.25 0 0 1 16 6.75a1.25 1.25 0 0 1 1.45-1.25M12 7a5 5 0 0 1 5 5 5 5 0 0 1-5 5 5 5 0 0 1-5-5 5 5 0 0 1 5-5m0 2a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3z" />
                                </svg>
                            </a>

                            <Link
                                :href="switchLocaleUrl"
                                class="inline-flex h-11 min-w-[2.75rem] items-center justify-center rounded-full border border-slate-200 bg-slate-100 px-4 text-sm font-semibold text-slate-600 transition hover:border-slate-300 hover:bg-slate-200 hover:text-brand-700"
                                @click="close"
                            >
                                {{ localeLabel }}
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style scoped>
.mobile-menu-enter-active,
.mobile-menu-leave-active {
    transition: transform 0.4s cubic-bezier(0.22, 1, 0.36, 1);
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
    transform: translateX(100%);
}

.mobile-menu-enter-to,
.mobile-menu-leave-from {
    transform: translateX(0);
}

.mobile-menu-panel {
    will-change: transform;
}

@media (prefers-reduced-motion: reduce) {
    .mobile-menu-enter-active,
    .mobile-menu-leave-active {
        transition-duration: 0.2s;
    }
}
</style>
