<?php

namespace App\Services;

use App\Repositories\FavouriteCountryRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavouriteCountryService
{
    protected FavouriteCountryRepository $repository;

    public function __construct(FavouriteCountryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function saveFavourite(array $validatedData, int $userId): void
    {
        $validatedData['user_id'] = $userId;

        DB::beginTransaction();

        try {
            $this->repository->create($validatedData);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to save favourite country: '.$e->getMessage());
            throw $e;
        }
    }
}
