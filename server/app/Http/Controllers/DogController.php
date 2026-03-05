<?php

namespace App\Http\Controllers;

use App\Models\Dog as CurrentModel;
use App\Models\Photo;
use App\Models\Vaccination;
use App\Http\Requests\StoreDogRequest as StoreCurrentModelRequest;
use App\Http\Requests\UpdateDogRequest as UpdateCurrentModelRequest;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DogController extends Controller
{
     use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->apiResponse(
            function () {
                return CurrentModel::all();
            }
        );
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(StoreCurrentModelRequest $request)
{
    return $this->apiResponse(function () use ($request) {
        return CurrentModel::create($request->validated());
    });
}


    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->apiResponse(function () use ($id) {
            return CurrentModel::findOrFail($id);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCurrentModelRequest $request, int $id)
    {
        return $this->apiResponse(function () use ($request, $id) {
            $row = CurrentModel::findOrFail($id);
            $row->update($request->validated());
            return $row;
        });
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(int $id)
    {
        return $this->apiResponse(function () use ($id) {
            DB::transaction(function () use ($id) {
                Vaccination::where('dogId', $id)->delete();
                Photo::where('dogId', $id)->delete();
                CurrentModel::findOrFail($id)->delete();
            });

            return ['id' => $id];
        });
    }
}
