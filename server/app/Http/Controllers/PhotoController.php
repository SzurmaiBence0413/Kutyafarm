<?php

namespace App\Http\Controllers;

use App\Models\Photo as CurrentModel;
use App\Http\Requests\StorePhotoRequest as StoreCurrentModelRequest;
use App\Http\Requests\UpdatePhotoRequest as UpdateCurrentModelRequest;


use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
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
        return $this->apiResponse(
            function () use ($request) {
                $path = $request->file('image')->store('photos', 'public');
                $imgUrl = url(Storage::url($path));

                return CurrentModel::create([
                    'dogId' => $request->input('dogId'),
                    'imgUrl' => $imgUrl,
                ]);
            }
        );
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
            if ($request->hasFile('image')) {
                $this->deleteStoredImageIfLocal($row->imgUrl);
                $path = $request->file('image')->store('photos', 'public');
                $row->imgUrl = url(Storage::url($path));
            }
            $row->save();
            return $row;
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->apiResponse(function () use ($id) {
            $row = CurrentModel::findOrFail($id);
            $this->deleteStoredImageIfLocal($row->imgUrl);
            $row->delete();
            return ['id' => $id];
        });
    }

    private function deleteStoredImageIfLocal(?string $imgUrl): void
    {
        if (!$imgUrl) {
            return;
        }

        $parsed = parse_url($imgUrl);
        $path = $parsed['path'] ?? '';
        $marker = '/storage/';
        $pos = strpos($path, $marker);
        if ($pos === false) {
            return;
        }

        $relative = ltrim(substr($path, $pos + strlen($marker)), '/');
        if ($relative !== '' && Storage::disk('public')->exists($relative)) {
            Storage::disk('public')->delete($relative);
        }
    }
}
