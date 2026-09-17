<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { onMounted, onUnmounted, ref, watch } from 'vue';
import { useI18n } from 'vue-i18n';
import ImagePlaceholder from '@/Components/Public/ImagePlaceholder.vue';
import { urlQuote, urlService } from '@/lib/publicUrls';

export interface HeroSlide {
    id: number;
    slug: string;
    titulo: string;
    hero_subtitulo: string | null;
    descripcion_corta: string;
    imagen_cabecera: string | null;
}

const props = defineProps<{
    slides: HeroSlide[];
    locale: string;
}>();

/** Tiempo visible por slide antes de avanzar (ms). */
const SLIDE_INTERVAL_MS = 10_000;

const { t } = useI18n();
const active = ref(0);
const paused = ref(false);
let timer: ReturnType<typeof setTimeout> | null = null;

function clearTimer() {
    if (timer) {
        clearTimeout(timer);
        timer = null;
    }
}

function scheduleNext() {
    clearTimer();

    if (props.slides.length <= 1 || paused.value) {
        return;
    }

    timer = setTimeout(advance, SLIDE_INTERVAL_MS);
}

function advance() {
    active.value = (active.value + 1) % props.slides.length;
    scheduleNext();
}

function goTo(index: number) {
    active.value = index;
    scheduleNext();
}

function next() {
    advance();
}

function prev() {
    active.value = (active.value - 1 + props.slides.length) % props.slides.length;
    scheduleNext();
}

watch(paused, (isPaused) => {
    if (isPaused) {
        clearTimer();
        return;
    }

    scheduleNext();
});

watch(
    () => props.slides.length,
    () => scheduleNext(),
);

onMounted(scheduleNext);
onUnmounted(clearTimer);
</script>

<template>
    <section
        data-site-hero
        class="relative -mt-16 overflow-hidden bg-brand-950 text-white"
        @mouseenter="paused = true"
        @mouseleave="paused = false"
        @focusin="paused = true"
        @focusout="paused = false"
    >
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-700/30 via-transparent to-transparent" />

        <div class="container-public relative pb-16 pt-32 md:pb-8 md:pt-24">
            <div class="hero-slider-stage">
                <div
                    v-for="(slide, index) in slides"
                    :key="slide.id"
                    class="hero-slide grid items-center gap-10 lg:grid-cols-2 lg:gap-16"
                    :class="{ 'is-active': index === active }"
                    :aria-hidden="index !== active"
                >
                    <div>
                        <p
                            v-if="slide.hero_subtitulo"
                            class="mb-3 text-sm font-semibold uppercase tracking-widest text-brand-300"
                        >
                            {{ slide.hero_subtitulo }}
                        </p>
                        <h1 class="mb-5 text-4xl font-bold leading-tight tracking-tight sm:text-5xl lg:text-6xl">
                            {{ slide.titulo }}
                        </h1>
                        <p class="mb-8 max-w-xl text-lg leading-relaxed text-slate-300">
                            {{ slide.descripcion_corta }}
                        </p>
                        <div class="flex flex-wrap items-center gap-4">
                            <Link
                                :href="urlQuote(locale)"
                                class="btn-primary btn-on-dark"
                                :tabindex="index === active ? 0 : -1"
                            >
                                {{ t('cta.request_quote') }}
                            </Link>
                            <Link
                                :href="urlService(locale, slide.slug)"
                                class="btn-secondary"
                                :tabindex="index === active ? 0 : -1"
                            >
                                {{ t('cta.view_service') }}
                            </Link>
                        </div>
                        <p
                            class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-800/50 px-4 py-1.5 text-sm text-brand-200"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            {{ t('cta.free_quote') }}
                        </p>
                    </div>
                    <div class="relative">
                        <div class="overflow-hidden rounded-2xl shadow-2xl">
                            <ImagePlaceholder
                                :src="slide.imagen_cabecera"
                                :alt="slide.titulo"
                                aspect="hero"
                            />
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="slides.length > 1" class="relative z-20 mt-10 flex items-center justify-between">
                <div class="flex gap-2">
                    <button
                        v-for="(_, i) in slides"
                        :key="i"
                        type="button"
                        class="h-2 rounded-full transition-all duration-500 ease-out"
                        :class="i === active ? 'w-8 bg-white' : 'w-2 bg-white/30 hover:bg-white/50'"
                        :aria-label="`Slide ${i + 1}`"
                        :aria-current="i === active ? 'true' : undefined"
                        @click="goTo(i)"
                    />
                </div>
                <div class="flex gap-2">
                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-white transition hover:bg-white/10"
                        aria-label="Previous slide"
                        @click="prev"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                    </button>
                    <button
                        type="button"
                        class="flex h-10 w-10 items-center justify-center rounded-full border border-white/20 text-white transition hover:bg-white/10"
                        aria-label="Next slide"
                        @click="next"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>
.hero-slider-stage {
    position: relative;
}

@media (min-width: 1024px) {
    .hero-slider-stage {
        min-height: 500px;
    }
}

.hero-slide {
    position: absolute;
    inset: 0;
    width: 100%;
    opacity: 0;
    transform: translateY(32px);
    z-index: 0;
    pointer-events: none;
    visibility: hidden;
    transition:
        opacity 1.25s cubic-bezier(0.22, 1, 0.36, 1),
        transform 1.25s cubic-bezier(0.22, 1, 0.36, 1),
        visibility 0s linear 1.25s;
}

.hero-slide.is-active {
    opacity: 1;
    transform: translateY(0);
    z-index: 10;
    pointer-events: auto;
    visibility: visible;
    transition:
        opacity 1.25s cubic-bezier(0.22, 1, 0.36, 1),
        transform 1.25s cubic-bezier(0.22, 1, 0.36, 1),
        visibility 0s linear 0s;
}

@media (max-width: 1023px) {
    .hero-slide {
        position: relative;
        inset: auto;
        height: 0;
        overflow: hidden;
    }

    .hero-slide.is-active {
        height: auto;
        overflow: visible;
    }
}

@media (prefers-reduced-motion: reduce) {
    .hero-slide {
        transform: none;
        transition: opacity 0.35s ease, visibility 0s linear 0.35s;
    }

    .hero-slide.is-active {
        transition: opacity 0.35s ease, visibility 0s linear 0s;
    }
}
</style>
