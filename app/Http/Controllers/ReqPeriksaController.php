<?php

namespace App\Http\Controllers;

use App\Models\req_periksa;
use App\Http\Requests\Storereq_periksaRequest;
use App\Http\Requests\Updatereq_periksaRequest;

class ReqPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storereq_periksaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storereq_periksaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\req_periksa  $req_periksa
     * @return \Illuminate\Http\Response
     */
    public function show(req_periksa $req_periksa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\req_periksa  $req_periksa
     * @return \Illuminate\Http\Response
     */
    public function edit(req_periksa $req_periksa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatereq_periksaRequest  $request
     * @param  \App\Models\req_periksa  $req_periksa
     * @return \Illuminate\Http\Response
     */
    public function update(Updatereq_periksaRequest $request, req_periksa $req_periksa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\req_periksa  $req_periksa
     * @return \Illuminate\Http\Response
     */
    public function destroy(req_periksa $req_periksa)
    {
        //
    }
}
