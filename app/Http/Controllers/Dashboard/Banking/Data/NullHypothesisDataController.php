<?php

namespace App\Http\Controllers\Dashboard\Banking\Data;

use App\Http\Controllers\Controller;
use App\Models\NullHypothesisData;
use Illuminate\Http\Request;
use App\Models\VariableMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NullHypothesisDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hypothesis = NullHypothesisData::orderBy('id','asc')->get();
        return view('dashboard.bank.nullhypothesisdata.index', compact('hypothesis'));
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
        //dd($request->all());

        $validator = Validator::make($request->all(), [
            'variable_1a' => 'required',
            'variable_1b' => 'required',
            'variable_2a' => 'required',
            'variable_2b' => 'required',
            'obs' => 'required|numeric',
            'fStatistic1' => 'required|numeric',
            'fStatistic2' => 'required|numeric',
            'prob1' => 'required|numeric',
            'prob2' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        $nS = new NullHypothesisData;
        $nS->null_hypothesis = strtoupper($request->variable_1a) . ' Does not Granger Cause ' . strtoupper($request->variable_1b);
        $nS->obs = $request->obs;
        $nS->fStatic = $request->fStatistic1;
        $nS->prob = $request->prob1;
        $nS->id_negara = 1;
        $nS->jenis = 'bank';
        $nS->save();

        $nS2 = new NullHypothesisData;
        $nS2->null_hypothesis = strtoupper($request->variable_2a) . ' Does not Granger Cause ' . strtoupper($request->variable_2b);
        $nS2->fStatic = $request->fStatistic2;
        $nS2->prob = $request->prob2;
        $nS2->id_negara = 1;
        $nS2->jenis = 'bank';
        $nS2->save();

        return response()->json(['code' => 200, 'message' => 'Data saved', 'data' => null], 200);
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
    public function edit($grupId, $dataId)
    {
        $nullHypothesis = NullHypothesisData::where('group_id', $grupId)->get()->toArray();

        $data = array();
        $getNull1 = explode(" ", $nullHypothesis[0]['null_hypothesis']);
        $getNull2 = explode(" ", $nullHypothesis[1]['null_hypothesis']);

        /* Get Null Hypothesis 1 */
        $data['nullId1'] = $nullHypothesis[0]['id'];
        $data['nullA_1'] = $getNull1[0];
        $data['nullA_2'] = $getNull1[5];
        $data['obs'] = $nullHypothesis[0]['obs'];
        $data['fStatic1'] = $nullHypothesis[0]['fStatic'];
        $data['prob1'] = $nullHypothesis[0]['prob'];

        /* Get Null Hypothesis 2 */
        $data['nullId2'] = $nullHypothesis[1]['id'];
        $data['nullB_1'] = $getNull2[0];
        $data['nullB_2'] = $getNull2[5];
        $data['fStatic2'] = $nullHypothesis[1]['fStatic'];
        $data['prob2'] = $nullHypothesis[1]['prob'];

        $var = VariableMaster::all();
        return view('dashboard.bank.nullhypothesisdata.edit', compact('nullHypothesis','var', 'data', 'grupId', 'dataId'));
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
        //dd($request->groupId);
        $validator = Validator::make($request->all(), [
            'variable_1a' => 'required',
            'variable_1b' => 'required',
            'variable_2a' => 'required',
            'variable_2b' => 'required',
            'obs' => 'required|numeric',
            'fStatistic1' => 'required|numeric',
            'fStatistic2' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid data', 'data' => $validator->errors()], 200);
        }

        $nS = NullHypothesisData::where(['group_id' => $request->groupId, 'id' => $request->dataId1])->first();
        $nS->null_hypothesis = strtoupper($request->variable_1a) . ' Does not Granger Cause ' . strtoupper($request->variable_1b);
        $nS->obs = $request->obs;
        $nS->fStatic = $request->fStatistic1;
        $nS->prob = $request->prob1;
        $nS->save();

        $nS2 = NullHypothesisData::where(['group_id' => $request->groupId, 'id' => $request->dataId2])->first();
        $nS2->null_hypothesis = strtoupper($request->variable_2a) . ' Does not Granger Cause ' . strtoupper($request->variable_2b);
        $nS2->fStatic = $request->fStatistic2;
        $nS2->prob = $request->prob2;
        $nS2->save();

        return response()->json(['code' => 200, 'message' => 'Data saved', 'data' => null], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NullHypothesisData  $nullHypothesisData
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'groupId' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
            }

            NullHypothesisData::where('group_id', $request->groupId)
                ->delete();

            return response()->json(['code' => 200, 'message' => 'Data deleted successfully', 'data' => null], 200);
        } catch (Exception $e) {
            return response()->json(['code' => 500, 'message' => $e->getMessage(), 'data' => null], 200);
        }
    }
}
