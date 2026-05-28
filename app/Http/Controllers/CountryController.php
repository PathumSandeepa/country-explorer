<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteRequest;
use App\Repositories\FavouriteCountryRepository;
use App\Services\CountryApiService;
use App\Services\FavouriteCountryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    protected CountryApiService $apiService;

    protected FavouriteCountryService $favouriteService;

    protected FavouriteCountryRepository $repository;

    public function __construct(
        CountryApiService $apiService,
        FavouriteCountryService $favouriteService,
        FavouriteCountryRepository $repository
    ) {
        $this->apiService = $apiService;
        $this->favouriteService = $favouriteService;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $userId = Auth::id();
        $searchResult = null;

        if ($request->has('search') && $request->search != '') {
            $searchResult = $this->apiService->searchCountry($request->search);
        }

        $savedCountries = $this->repository->getAllForUser($userId);

        return view('dashboard', compact('searchResult', 'savedCountries'));
    }

    public function store(StoreFavouriteRequest $request)
    {
        try {
            $this->favouriteService->saveFavourite($request->validated(), Auth::id());

            return redirect()
                ->route('dashboard')
                ->with('success', 'Country saved successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'You have already saved this country, or an error occurred.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate(['personal_note' => 'nullable|string|max:500']);

        $this->repository->updateNote($id, Auth::id(), $request->personal_note);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Note updated successfully!');
    }

    public function destroy($id)
    {
        $this->repository->delete($id, Auth::id());

        return redirect()
            ->route('dashboard')
            ->with('success', 'Country removed from favourites.');
    }
}
