<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

export type LandingReview = {
    name: string;
    text: string;
    rating?: number;
    relative_time?: string | null;
    profile_url?: string | null;
    photo_url?: string | null;
};

const props = defineProps<{
    reviews: LandingReview[];
    googleReviewsUrl: string;
    showSampleNote?: boolean;
}>();

const { t } = useI18n();

const currentIndex = ref(0);
const visibleCount = ref(1);
const paused = ref(false);
const brokenPhotos = ref<Set<string>>(new Set());

let timer: ReturnType<typeof setInterval> | null = null;
let mediaQuery: MediaQueryList | null = null;

function updateVisibleCount() {
    visibleCount.value = window.matchMedia('(min-width: 768px)').matches ? 3 : 1;
}

const visibleReviews = computed(() => {
    const n = props.reviews.length;
    if (n === 0) {
        return [];
    }

    const count = Math.min(visibleCount.value, n);
    return Array.from({ length: count }, (_, offset) => {
        const idx = (currentIndex.value + offset) % n;
        return { ...props.reviews[idx], _key: `${idx}-${currentIndex.value}` };
    });
});

function goNext() {
    const n = props.reviews.length;
    if (n === 0) {
        return;
    }
    currentIndex.value = (currentIndex.value + 1) % n;
}

function goPrev() {
    const n = props.reviews.length;
    if (n === 0) {
        return;
    }
    currentIndex.value = (currentIndex.value - 1 + n) % n;
}

function startTimer() {
    stopTimer();
    if (props.reviews.length <= visibleCount.value) {
        return;
    }
    timer = setInterval(() => {
        if (!paused.value) {
            goNext();
        }
    }, 5500);
}

function stopTimer() {
    if (timer) {
        clearInterval(timer);
        timer = null;
    }
}

function onBreakpointChange() {
    updateVisibleCount();
    startTimer();
}

function onPhotoError(url: string) {
    brokenPhotos.value = new Set(brokenPhotos.value).add(url);
}

onMounted(() => {
    updateVisibleCount();
    mediaQuery = window.matchMedia('(min-width: 768px)');
    mediaQuery.addEventListener('change', onBreakpointChange);
    startTimer();
});

onUnmounted(() => {
    mediaQuery?.removeEventListener('change', onBreakpointChange);
    stopTimer();
});
</script>

<template>
    <section class="border-t border-slate-200 bg-slate-50 py-12 md:py-16">
        <div class="container-public">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.reviews_title') }}</h2>
                    <p v-if="showSampleNote" class="mt-2 text-sm text-slate-500">{{ t('landing.reviews_note') }}</p>
                </div>
                <a
                    :href="googleReviewsUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-outline shrink-0 text-sm"
                >
                    {{ t('landing.reviews_view_google') }}
                </a>
            </div>

            <div
                v-if="reviews.length"
                class="relative mt-8"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
                @focusin="paused = true"
                @focusout="paused = false"
            >
                <div
                    class="grid gap-4 md:grid-cols-3"
                    aria-live="polite"
                    aria-atomic="true"
                >
                    <blockquote
                        v-for="review in visibleReviews"
                        :key="review._key"
                        class="card flex h-full flex-col p-6 transition-opacity duration-500"
                    >
                        <div class="mb-3 flex items-center gap-3">
                            <img
                                v-if="review.photo_url && !brokenPhotos.has(review.photo_url)"
                                :src="review.photo_url"
                                @error="onPhotoError(review.photo_url!)"
                                :alt="review.name"
                                class="h-11 w-11 shrink-0 rounded-full object-cover ring-2 ring-white shadow-sm ring-slate-200"
                                loading="lazy"
                                referrerpolicy="no-referrer"
                            />
                            <div
                                v-else
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-100 text-sm font-bold text-brand-700 ring-2 ring-white shadow-sm ring-slate-200"
                                aria-hidden="true"
                            >
                                {{ review.name.charAt(0) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <footer class="truncate text-sm font-semibold text-brand-950">
                                    <a
                                        v-if="review.profile_url"
                                        :href="review.profile_url"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="hover:text-brand-600"
                                    >
                                        {{ review.name }}
                                    </a>
                                    <span v-else>{{ review.name }}</span>
                                </footer>
                                <p v-if="review.relative_time" class="text-xs text-slate-400">{{ review.relative_time }}</p>
                            </div>
                        </div>
                        <div class="mb-3 flex gap-0.5 text-amber-400" :aria-label="`${review.rating ?? 5} estrellas`">
                            <span
                                v-for="s in 5"
                                :key="s"
                                class="text-base"
                                :class="s <= (review.rating ?? 5) ? 'opacity-100' : 'opacity-25'"
                            >★</span>
                        </div>
                        <p class="flex-1 text-sm leading-relaxed text-slate-700">“{{ review.text }}”</p>
                    </blockquote>
                </div>

                <div
                    v-if="reviews.length > visibleCount"
                    class="mt-6 flex items-center justify-center gap-4"
                >
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-300 hover:text-brand-700"
                        :aria-label="t('landing.reviews_prev')"
                        @click="goPrev"
                    >
                        ‹
                    </button>
                    <div class="flex gap-1.5">
                        <button
                            v-for="(_, i) in reviews"
                            :key="i"
                            type="button"
                            class="h-2 rounded-full transition-all"
                            :class="i === currentIndex ? 'w-6 bg-brand-600' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                            :aria-label="`${t('landing.reviews_go_to')} ${i + 1}`"
                            @click="currentIndex = i"
                        />
                    </div>
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-300 hover:text-brand-700"
                        :aria-label="t('landing.reviews_next')"
                        @click="goNext"
                    >
                        ›
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
