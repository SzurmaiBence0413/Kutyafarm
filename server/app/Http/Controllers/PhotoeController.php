<?php

namespace App\Http\Controllers;

use App\Models\Photoe;
use App\Http\Requests\StorePhotoeRequest;
use App\Http\Requests\UpdatePhotoeRequest;

class PhotoeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhotoeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Photoe $photoe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhotoeRequest $request, Photoe $photoe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Photoe $photoe)
    {
        //
    }
}
