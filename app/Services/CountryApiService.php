<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CountryApiService
{
    public function searchCountry(string $name): array
    {
        try {
            return Cache::remember('country_search_'.strtolower($name), 86400, function () use ($name) {
                $response = Http::timeout(5)->get("https://restcountries.com/v3.1/name/{$name}");

                if ($response->failed()) {
                    return [];
                }

                return $response->json();
            });
        } catch (Exception $e) {
            Log::error('RestCountries API failed: '.$e->getMessage());

            return [];
        }
    }
}
