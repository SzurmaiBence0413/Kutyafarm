<?php

namespace App\Http\Controllers;

use App\Models\Dog;
use App\Http\Requests\StoreDogRequest;
use App\Http\Requests\UpdateDogRequest;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DogController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        try {
            $rows = Dog::all();
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
    public function store(StoreDogRequest $request)
    {
        try {
            $row = Dog::create($request->all());
            $data = [
                'message' => 'OK',
                'data' => $row
            ];
            return response()->json($data, 201, options: JSON_UNESCAPED_UNICODE);

        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json([
                    'message' => 'Insert error: This chip number already exists',
                    'data' => [
                        'chipNumber' => $request->chipNumber
                    ]
                ], 409, options: JSON_UNESCAPED_UNICODE);
            }
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $row = Dog::find($id);
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
    public function update(UpdateDogRequest $request, int $id)
    {
        $row = Dog::find($id);
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
        $row = Dog::find($id);
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
                'data' => null
            ];
        }
        return response()->json($data, $status, options: JSON_UNESCAPED_UNICODE);
    }
}
