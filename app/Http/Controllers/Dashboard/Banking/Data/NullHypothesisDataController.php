<?php

namespace App\Http\Controllers\Dashboard\Banking\Data;

use App\Http\Controllers\Controller;
use App\Models\NullHypothesisData;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use Illuminate\Support\Facades\Validator;

class NullHypothesisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.bank.nullhypothesisdata.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $var = VariableMaster::all();
        return view('dashboard.bank.nullhypothesisdata.create', compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());

        /* $valitator = Validator::make($request->all(), [
            ''
        ]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NullHypothesisData  $nullHypothesisData
     * @return \Illuminate\Http\Response
     */
    public function show(NullHypothesisData $nullHypothesisData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NullHypothesisData  $nullHypothesisData
     * @return \Illuminate\Http\Response
     */
    public function edit(NullHypothesisData $nullHypothesisData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NullHypothesisData  $nullHypothesisData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NullHypothesisData $nullHypothesisData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NullHypothesisData  $nullHypothesisData
     * @return \Illuminate\Http\Response
     */
    public function destroy(NullHypothesisData $nullHypothesisData)
    {
        //
    }
}
