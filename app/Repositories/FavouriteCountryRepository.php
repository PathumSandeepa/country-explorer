<?php

namespace App\Repositories;

use App\Models\FavouriteCountry;
use Illuminate\Database\Eloquent\Collection;

class FavouriteCountryRepository
{
   public function getAllForUser(int $userId): Collection
   {
      return FavouriteCountry::where('user_id', $userId)
         ->orderBy('created_at', 'desc')
         ->get();
   }

   public function create(array $data): FavouriteCountry
   {
      return FavouriteCountry::create($data);
   }

   public function updateNote(int $id, int $userId, string $note): bool
   {
      $country = FavouriteCountry::where('id', $id)->where('user_id', $userId)->firstOrFail();

      return $country->update(['personal_note' => $note]);
   }

   public function delete(int $id, int $userId): bool
   {
      $country = FavouriteCountry::where('id', $id)->where('user_id', $userId)->firstOrFail();

      return $country->delete();
   }
}
