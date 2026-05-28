<?php

namespace App\Repositories;

use App\Models\FavouriteCountry;
use Illuminate\Database\Eloquent\Collection;

interface FavouriteCountryRepositoryInterface
{
    public function getAllForUser(int $userId): Collection;

    public function create(array $data): FavouriteCountry;

    public function updateNote(int $id, int $userId, string $note): bool;

    public function delete(int $id, int $userId): bool;
}
