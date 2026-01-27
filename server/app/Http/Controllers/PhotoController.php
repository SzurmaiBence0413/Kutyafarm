<?php

namespace App\Http\Controllers;

use App\Models\Photoe;
use App\Http\Requests\StorePhotoeRequest;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoeRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Photo;
use Illuminate\Database\QueryException;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rows = Photo::all();
            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $rows
            ];
        } catch (\Exception $e) {
            $status = 500;
            $data = [
                'message' => "Server error {$e->getCode()}",
                'data' => []
            ];
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoRequest $request)
    {
        try {
            $row = Photo::create($request->all());
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
            return response()->json($data, 201, options: JSON_UNESCAPED_UNICODE);

        } catch (QueryException $e) {
            if ($e->getCode() == 23000 || str_contains($e->getMessage(), 'Duplicate entery')) {
                $data = [
                    'message' => 'Insert error: The given name alrady exist, please choose another one',
                    'data' => [
                        'id' => $request->input('id')
                    ]
                ];
                return response()->json($data, 409, options: JSON_UNESCAPED_UNICODE);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $row = Photo::find($id);
        if ($row) {
            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
        } else {
            $status = 404;
            $data = [
                'message' => "Not found id: $id",
                'data' => null
            ];
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoRequest $request, int $id)
    {
        $row = Photo::find($id);
        if ($row) {
            $row->update($request->all());

            $status = 200;
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
        } else {
            $status = 404;
            $data = [
                'message' => "Patch error. Not found id: $id",
                'data' => null
            ];
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $row = Photo::find($id);
        if ($row) {
            $row->delete();

            $status = 200;
            $data = [
                'message' => "OK",
                'data' => [
                    'id' => $id
                ]
            ];
        } else {
            $status = 404;
            $data = [
                'message' => "Delete error. Not found id: $id",
                'data=' => null
            ];
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }
}
