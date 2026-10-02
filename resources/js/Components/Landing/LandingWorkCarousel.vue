<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';

const props = defineProps<{
    photos: string[];
    altLabel: string;
}>();

const { t } = useI18n();

const currentIndex = ref(0);
const visibleCount = ref(1);
const paused = ref(false);

let timer: ReturnType<typeof setInterval> | null = null;
let mediaQuery: MediaQueryList | null = null;

function updateVisibleCount() {
    visibleCount.value = window.matchMedia('(min-width: 768px)').matches ? 3 : 1;
}

const visiblePhotos = computed(() => {
    const n = props.photos.length;
    if (n === 0) {
        return [];
    }

    const count = Math.min(visibleCount.value, n);
    return Array.from({ length: count }, (_, offset) => {
        const idx = (currentIndex.value + offset) % n;
        return { src: props.photos[idx], _key: `${idx}-${currentIndex.value}` };
    });
});

function goNext() {
    const n = props.photos.length;
    if (n === 0) {
        return;
    }
    currentIndex.value = (currentIndex.value + 1) % n;
}

function goPrev() {
    const n = props.photos.length;
    if (n === 0) {
        return;
    }
    currentIndex.value = (currentIndex.value - 1 + n) % n;
}

function startTimer() {
    stopTimer();
    if (props.photos.length <= visibleCount.value) {
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
    <section class="py-12 md:py-16">
        <div class="container-public">
            <h2 class="text-2xl font-bold text-brand-950">{{ t('landing.work_gallery_title') }}</h2>

            <div
                v-if="photos.length"
                class="relative mt-8"
                @mouseenter="paused = true"
                @mouseleave="paused = false"
            >
                <div
                    class="grid gap-4"
                    :class="visibleCount >= 3 ? 'md:grid-cols-3' : 'grid-cols-1'"
                    aria-live="polite"
                >
                    <div
                        v-for="(photo, i) in visiblePhotos"
                        :key="photo._key"
                        class="overflow-hidden rounded-2xl bg-slate-200 ring-1 ring-slate-200 shadow-sm"
                    >
                        <img
                            :src="photo.src"
                            :alt="`${altLabel} ${i + 1}`"
                            class="aspect-video w-full object-cover transition-opacity duration-500 md:aspect-[4/3]"
                            loading="lazy"
                        />
                    </div>
                </div>

                <div
                    v-if="photos.length > visibleCount"
                    class="mt-6 flex items-center justify-center gap-4"
                >
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-300 hover:text-brand-700"
                        :aria-label="t('landing.work_prev')"
                        @click="goPrev"
                    >
                        ‹
                    </button>
                    <div class="flex gap-1.5">
                        <button
                            v-for="(_, i) in photos"
                            :key="i"
                            type="button"
                            class="h-2 rounded-full transition-all"
                            :class="i === currentIndex ? 'w-6 bg-brand-600' : 'w-2 bg-slate-300 hover:bg-slate-400'"
                            :aria-label="`${t('landing.work_go_to')} ${i + 1}`"
                            @click="currentIndex = i"
                        />
                    </div>
                    <button
                        type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-brand-300 hover:text-brand-700"
                        :aria-label="t('landing.work_next')"
                        @click="goNext"
                    >
                        ›
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
