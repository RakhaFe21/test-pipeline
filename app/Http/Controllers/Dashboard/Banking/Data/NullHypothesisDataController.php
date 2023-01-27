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

    public function getVariableValue()
    {
        $variable = ['NPF','CAR','IPR','FDR'];
        $table = '<thead class="text-xs uppercase bg-gray-200" id="theadVariable">';
        $table.= '<th scope="col" class="py-3 px-6">VARIABLE</th>';

        foreach ($variable as $item) {
            $table.= '<th scope="col" class="py-3 px-6">I'.$item.'</th>';
        }

        $table.= '<th scope="col" class="py-3 px-6">TOTAL</th></thead>';
        $table.= '<tbody id="tbodyVariable">';

        $totalMatrix = array();
        foreach ($variable as $item) {
            $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
            $table.= '<td class="border py-4 px-6">I'.$item.'</td>';

            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $table.= '<td class="border py-4 px-6">'.$valNpf.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valCar.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valIpr.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valFdr.'</td>';

            /* Get sum of matrix */
            $sumAll = $valNpf + $valCar + $valIpr + $valFdr;
            $totalMatrix['arrTotal'] = $sumAll;

            $table.= '<td class="border py-4 px-6">'.$sumAll.'</td>';

            $table.= '</tr>';
        }

        $table.= '<tr><td colspan="5" class="border py-4 px-6">MAX</td><td class="border py-4 px-6">'.$totalMatrix['arrTotal'].'</td></tr>';

        $table.= '</tbody>';

        return $table;
    }

    public  function  getNormalizedVariableValue()
    {
        $variable = ['NPF','CAR','IPR','FDR'];
        $table = '<thead class="text-xs uppercase bg-gray-200" id="theadVariable">';

        $table.= '<tbody id="tbodyVariable">';

        /*
         * Get matrix max
         * */
        $totalMatrix = array();
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            /* Get sum of matrix */
            $sumAll = $valNpf + $valCar + $valIpr + $valFdr;
            $totalMatrix['arrTotal'] = $sumAll;
        }
        /* End get matrix max */

        /*
         * Get normalized data
         * */
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $countNpf = $valNpf / $totalMatrix['arrTotal'];
            $countCar = $valCar / $totalMatrix['arrTotal'];
            $countIpr = $valIpr / $totalMatrix['arrTotal'];
            $countFdr = $valFdr / $totalMatrix['arrTotal'];

            $fixedNpf = ($countNpf == 0) ? 0 : number_format($countNpf, 2);
            $fixedCar = ($countCar == 0) ? 0 : number_format($countCar, 2);
            $fixedIpr = ($countIpr == 0) ? 0 : number_format($countIpr, 2);
            $fixedFdr = ($countFdr == 0) ? 0 : number_format($countFdr, 2);

            $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
            $table.= '<td class="border py-4 px-6">I'.$item.'</td>';

            $table.= '<td class="border py-4 px-6">'.$fixedNpf.'</td>';
            $table.= '<td class="border py-4 px-6">'.$fixedCar.'</td>';
            $table.= '<td class="border py-4 px-6">'.$fixedIpr.'</td>';
            $table.= '<td class="border py-4 px-6">'.$fixedFdr.'</td>';

            $table.= '</tr>';
        }
        /* End get normalized data */

        $table.= '</tbody>';

        return $table;
    }

    public  function  getProb($nullHypothesis)
    {
        $getProb = NullHypothesisData::where('null_hypothesis', $nullHypothesis)->select(['prob'])->first();
        if(!empty($getProb->prob)) {
            $calcProb = $getProb->prob * 100;
        } else {
            $calcProb = 0;
        }

        /* Find matrix value */
        if($calcProb > 100) {
            $matrix = 1;
        } else if($calcProb >= 50 && $calcProb <= 100) {
            $matrix = 2;
        } else if($calcProb >= 10 && $calcProb < 50) {
            $matrix = 3;
        } else if($calcProb < 10) {
            $matrix = 4;
        } else {
            $matrix = 0;
        }

        return $matrix;
    }

    public function getIdentityMatrix()
    {
        $variable = ['NPF','CAR','IPR','FDR'];

        $table = '<tbody id="tbodyVariable">';

        $totalMatrix = array();
        foreach ($variable as $item) {
            $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';

            $valNpf = ($item == $variable[0]) ? 1: 0;
            $valCar = ($item == $variable[1]) ? 1: 0;
            $valIpr = ($item == $variable[2]) ? 1: 0;
            $valFdr = ($item == $variable[3]) ? 1: 0;

            $table.= '<td class="border py-4 px-6">'.$valNpf.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valCar.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valIpr.'</td>';
            $table.= '<td class="border py-4 px-6">'.$valFdr.'</td>';

            $table.= '</tr>';
        }

        $table.= '</tbody>';

        return $table;
    }

}
