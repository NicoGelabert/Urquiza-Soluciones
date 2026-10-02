<?php

return [
    'places_api_key' => env('GOOGLE_PLACES_API_KEY'),
    'place_id' => env('GOOGLE_PLACE_ID'),
    'reviews_cache_minutes' => (int) env('GOOGLE_REVIEWS_CACHE_MINUTES', 60 * 24),
];
