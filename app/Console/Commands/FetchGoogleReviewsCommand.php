<?php

namespace App\Console\Commands;

use App\Services\GooglePlaceReviewsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchGoogleReviewsCommand extends Command
{
    protected $signature = 'google-reviews:fetch {--find-place : Buscar Place ID por texto (requiere API key)}';

    protected $description = 'Comprueba la conexión con Google Places y muestra reseñas cacheadas';

    public function handle(GooglePlaceReviewsService $service): int
    {
        if ($this->option('find-place')) {
            return $this->findPlaceId();
        }

        $reviews = $service->getReviews(5);

        if ($reviews === []) {
            $this->warn('No hay reseñas. Configura GOOGLE_PLACES_API_KEY + GOOGLE_PLACE_ID o rellena config/google_reviews.php → manual.');
            $this->line('Perfil: '.$service->profileUrl());

            return self::FAILURE;
        }

        $this->info('Reseñas obtenidas: '.count($reviews));
        foreach ($reviews as $i => $review) {
            $this->newLine();
            $this->line('#'.($i + 1).' '.$review['name'].' ('.$review['rating'].'★) — '.$review['source']);
            if ($review['relative_time']) {
                $this->line($review['relative_time']);
            }
            $this->line($review['text']);
        }

        return self::SUCCESS;
    }

    private function findPlaceId(): int
    {
        $apiKey = config('google.places_api_key');
        if (! $apiKey) {
            $this->error('Define GOOGLE_PLACES_API_KEY en .env');

            return self::FAILURE;
        }

        $response = Http::withHeaders([
            'X-Goog-Api-Key' => $apiKey,
            'X-Goog-FieldMask' => 'places.id,places.displayName,places.formattedAddress',
            'Content-Type' => 'application/json',
        ])->post('https://places.googleapis.com/v1/places:searchText', [
            'textQuery' => 'Urquiza Soluciones Málaga',
            'languageCode' => 'es',
            'regionCode' => 'ES',
        ]);

        if (! $response->successful()) {
            $this->error('Text Search falló: '.$response->status());
            $this->line($response->body());

            return self::FAILURE;
        }

        foreach ($response->json('places') ?? [] as $place) {
            $this->line(($place['displayName']['text'] ?? '?').' — '.($place['formattedAddress'] ?? ''));
            $this->info('GOOGLE_PLACE_ID='.($place['id'] ?? ''));
        }

        return self::SUCCESS;
    }
}
