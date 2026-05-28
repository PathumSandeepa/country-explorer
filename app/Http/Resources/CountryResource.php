<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'country_code' => $this['cca3'] ?? 'N/A',
            'name' => $this['name']['common'] ?? 'Unknown',
            'capital' => $this['capital'][0] ?? 'N/A',
            'flag_url' => $this['flags']['svg'] ?? '',
        ];
    }
}
