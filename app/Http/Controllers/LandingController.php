<?php

namespace App\Http\Controllers;

use App\Models\landing;
use App\Http\Requests\StorelandingRequest;
use App\Http\Requests\UpdatelandingRequest;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          return view('pages.landing');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorelandingRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(landing $landing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(landing $landing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatelandingRequest $request, landing $landing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(landing $landing)
    {
        //
    }
}
