<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GooglePlaceReviewsService
{
    /**
     * @return array<int, array{name: string, text: string, rating: int, relative_time: ?string, profile_url: ?string, photo_url: ?string, source: string}>
     */
    public function getReviews(?int $limit = null): array
    {
        $limit = $limit ?? (int) config('google_reviews.max_display', 6);

        if (! config('google.places_api_key') || ! config('google.place_id')) {
            return $this->manualReviews($limit);
        }

        $fromApi = $this->fetchFromApi($limit);

        if ($fromApi !== []) {
            return $fromApi;
        }

        return $this->manualReviews($limit);
    }

    public function profileUrl(): string
    {
        return (string) config('google_reviews.profile_url');
    }

    /**
     * @return array<int, array{name: string, text: string, rating: int, relative_time: ?string, profile_url: ?string, photo_url: ?string, source: string}>
     */
    private function fetchFromApi(int $limit): array
    {
        $apiKey = config('google.places_api_key');
        $placeId = config('google.place_id');

        if (! $apiKey || ! $placeId) {
            return [];
        }

        $cacheKey = 'google_place_reviews:'.md5($placeId);
        $minutes = config('google.reviews_cache_minutes', 1440);

        return Cache::remember($cacheKey, now()->addMinutes($minutes), function () use ($apiKey, $placeId, $limit) {
            try {
                $response = Http::withHeaders([
                    'X-Goog-Api-Key' => $apiKey,
                    'X-Goog-FieldMask' => 'reviews,rating,userRatingCount,googleMapsUri',
                ])->get('https://places.googleapis.com/v1/places/'.$placeId);

                if (! $response->successful()) {
                    Log::warning('Google Places reviews request failed', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);

                    return [];
                }

                $reviews = $response->json('reviews') ?? [];
                $mapped = [];

                foreach ($reviews as $review) {
                    $text = trim((string) ($review['text']['text'] ?? $review['originalText']['text'] ?? ''));
                    if ($text === '') {
                        continue;
                    }

                    $author = $review['authorAttribution'] ?? [];

                    $mapped[] = [
                        'name' => (string) ($author['displayName'] ?? 'Cliente de Google'),
                        'text' => $text,
                        'rating' => (int) ($review['rating'] ?? 5),
                        'relative_time' => $review['relativePublishTimeDescription'] ?? null,
                        'profile_url' => $author['uri'] ?? null,
                        'photo_url' => $author['photoUri'] ?? null,
                        'source' => 'google',
                    ];

                    if (count($mapped) >= $limit) {
                        break;
                    }
                }

                return $mapped;
            } catch (\Throwable $e) {
                Log::warning('Google Places reviews exception', ['message' => $e->getMessage()]);

                return [];
            }
        });
    }

    /**
     * @return array<int, array{name: string, text: string, rating: int, relative_time: ?string, profile_url: ?string, photo_url: ?string, source: string}>
     */
    private function manualReviews(int $limit): array
    {
        $items = config('google_reviews.manual', []);

        return collect($items)
            ->take($limit)
            ->map(fn (array $row) => [
                'name' => (string) ($row['name'] ?? ''),
                'text' => (string) ($row['text'] ?? ''),
                'rating' => (int) ($row['rating'] ?? 5),
                'relative_time' => $row['relative_time'] ?? null,
                'profile_url' => $row['profile_url'] ?? null,
                'photo_url' => $row['photo_url'] ?? null,
                'source' => 'manual',
            ])
            ->filter(fn (array $r) => $r['name'] !== '' && $r['text'] !== '')
            ->values()
            ->all();
    }
}
