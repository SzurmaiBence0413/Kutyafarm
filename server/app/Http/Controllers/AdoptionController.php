<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdoptionRequest;
use App\Http\Requests\UpdateAdoptionStatusRequest;
use App\Models\AdoptionRequest as AdoptionRequestModel;
use App\Models\User;
use Illuminate\Http\Request;

class AdoptionController extends Controller
{
    public function store(StoreAdoptionRequest $request)
    {
        return $this->apiResponse(function () use ($request) {
            /** @var User $user */
            $user = $request->user();

            if (!$user || !$user->isAdopter()) {
                abort(403, 'Only adopters can create adoption requests.');
            }

            $row = AdoptionRequestModel::create([
                'dogId' => $request->validated('dogId'),
                'userId' => $user->id,
                'fullName' => $request->validated('fullName'),
                'email' => $request->validated('email'),
                'phone' => $request->validated('phone'),
                'city' => $request->validated('city'),
                'message' => $request->validated('message'),
                'status' => AdoptionRequestModel::STATUS_PENDING,
            ]);

            $row->load(['dog:id,dogName,chipNumber']);
            return $row;
        });
    }

    public function index(Request $request)
    {
        return $this->apiResponse(function () use ($request) {
            /** @var User $user */
            $user = $request->user();

            if (!$user) {
                abort(401);
            }

            if ($user->isAdmin()) {
                return AdoptionRequestModel::query()
                    ->with(['dog:id,dogName,chipNumber'])
                    ->orderByDesc('id')
                    ->get();
            }

            if ($user->isAdopter()) {
                return AdoptionRequestModel::query()
                    ->with(['dog:id,dogName,chipNumber'])
                    ->where('userId', $user->id)
                    ->orderByDesc('id')
                    ->get();
            }

            abort(403, 'Not allowed to list adoption requests.');
        });
    }

    public function updateStatus(UpdateAdoptionStatusRequest $request, int $id)
    {
        return $this->apiResponse(function () use ($request, $id) {
            /** @var User $user */
            $user = $request->user();

            if (!$user || !$user->isAdmin()) {
                abort(403, 'Only admins can update adoption request status.');
            }

            $row = AdoptionRequestModel::query()->findOrFail($id);
            $row->status = $request->validated('status');
            $row->save();

            $row->load(['dog:id,dogName,chipNumber']);
            return $row;
        });
    }
}
