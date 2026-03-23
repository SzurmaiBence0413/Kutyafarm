<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavouriteRequest;
use App\Models\Favourite;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    public function index(Request $request)
    {
        return $this->apiResponse(function () use ($request) {
            return Favourite::query()
                ->where('userId', $request->user()->id)
                ->orderByDesc('id')
                ->get();
        });
    }

    public function store(StoreFavouriteRequest $request)
    {
        return $this->apiResponse(function () use ($request) {
            return Favourite::firstOrCreate([
                'userId' => $request->user()->id,
                'dogId' => $request->validated('dogId'),
            ]);
        });
    }

    public function destroy(Request $request, int $dogId)
    {
        return $this->apiResponse(function () use ($request, $dogId) {
            Favourite::query()
                ->where('userId', $request->user()->id)
                ->where('dogId', $dogId)
                ->delete();

            return ['dogId' => $dogId];
        });
    }
}
