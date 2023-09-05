<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dashboard\Banking\Data\Exception;
use App\Http\Controllers\Service\IndexServiceController;
use App\Models\NullHypothesisData;
use App\Models\VariableMaster;
use App\Models\AdditionalData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Phpml\Math\Matrix;
use App\Http\Controllers\Service\SpreadsheetServiceController as Excel;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class NullHypothesisDataController extends Controller
{
    private $country;
    private $indexService;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
        try {
            $this->indexService = new IndexServiceController($this->country->id);
        } catch (\Throwable $th) {
            return abort(500, 'Something went wrong');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hypothesis = NullHypothesisData::orderBy('id','asc')
        ->where('id_negara', $this->country->id)
        ->where('jenis', 'a')
        ->get();
        return view('dashboard.bank.ibri.nullhypothesisdata.index', compact('hypothesis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $var = VariableMaster::all();
        return view('dashboard.bank.ibri.nullhypothesisdata.create', compact('var'));
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
        $nS->id_negara = $this->country->id;
        $nS->jenis = 'bank';
        $nS->save();

        $nS2 = new NullHypothesisData;
        $nS2->null_hypothesis = strtoupper($request->variable_2a) . ' Does not Granger Cause ' . strtoupper($request->variable_2b);
        $nS2->fStatic = $request->fStatistic2;
        $nS2->prob = $request->prob2;
        $nS2->id_negara = $this->country->id;
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
    public function edit($code, $grupId = null, $dataId = null)
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
        return view('dashboard.bank.ibri.nullhypothesisdata.edit', compact('nullHypothesis','var', 'data', 'grupId', 'dataId', 'code'));
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
        } catch (\Exception $e) {
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

        $table.= '<tr><td colspan="5" class="border py-4 px-6"><strong>MAX</strong></td><td class="border py-4 px-6"><strong>'.$totalMatrix['arrTotal'].'</strong></td></tr>';

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

            $table.= '<td class="border py-4 px-6'.($fixedNpf == 0 ? ' text-ds-yellow font-medium' : '').'">'.$fixedNpf.'</td>';
            $table.= '<td class="border py-4 px-6'.($fixedCar == 0 ? ' text-ds-yellow font-medium' : '').'">'.$fixedCar.'</td>';
            $table.= '<td class="border py-4 px-6'.($fixedIpr == 0 ? ' text-ds-yellow font-medium' : '').'">'.$fixedIpr.'</td>';
            $table.= '<td class="border py-4 px-6'.($fixedFdr == 0 ? ' text-ds-yellow font-medium' : '').'">'.$fixedFdr.'</td>';

            $table.= '</tr>';
        }
        /* End get normalized data */

        $table.= '</tbody>';

        return $table;
    }

    public  function  getProb($nullHypothesis)
    {
        $getProb = NullHypothesisData::where('id_negara', $this->country->id)->where('null_hypothesis', $nullHypothesis)->select(['prob'])->first();
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

    public function identityMatrix()
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

            $table.= '<td class="border py-4 px-6'.($valNpf == 1 ? ' text-ds-yellow font-medium' : '').'">'.$valNpf.'</td>';
            $table.= '<td class="border py-4 px-6'.($valCar == 1 ? ' text-ds-yellow font-medium' : '').'">'.$valCar.'</td>';
            $table.= '<td class="border py-4 px-6'.($valIpr == 1 ? ' text-ds-yellow font-medium' : '').'">'.$valIpr.'</td>';
            $table.= '<td class="border py-4 px-6'.($valFdr == 1 ? ' text-ds-yellow font-medium' : '').'">'.$valFdr.'</td>';

            $table.= '</tr>';
        }

        $table.= '</tbody>';

        return $table;
    }

    public function identityMatrixY()
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

            $fixedNpf = ($countNpf == 0) ? 1 : $this->getIdentityMatrix(number_format($countNpf, 2)) - number_format($countNpf, 2);
            $fixedCar = ($countCar == 0) ? 1 : $this->getIdentityMatrix(number_format($countCar, 2)) - number_format($countCar, 2);
            $fixedIpr = ($countIpr == 0) ? 1 : $this->getIdentityMatrix(number_format($countIpr, 2)) - number_format($countIpr, 2);
            $fixedFdr = ($countFdr == 0) ? 1 : $this->getIdentityMatrix(number_format($countFdr, 2)) - number_format($countFdr, 2);

            $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';

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

    public function getIdentityMatrix($var)
    {
        $variable = ['NPF','CAR','IPR','FDR'];
        foreach ($variable as $v => $k) {
            return $v;
        }
    }
    public function getMinvers()
    {
        $variable = ['NPF','CAR','IPR','FDR'];

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
        $arrNpf = array();
        $arrCar = array();
        $arrIpr = array();
        $arrFdr = array();
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $countNpf = $valNpf / $totalMatrix['arrTotal'];
            $countCar = $valCar / $totalMatrix['arrTotal'];
            $countIpr = $valIpr / $totalMatrix['arrTotal'];
            $countFdr = $valFdr / $totalMatrix['arrTotal'];

            $fixedNpf = ($countNpf == 0) ? 1 : $this->getIdentityMatrix($countNpf) - $countNpf;
            $fixedCar = ($countCar == 0) ? 1 : $this->getIdentityMatrix($countCar) - $countCar;
            $fixedIpr = ($countIpr == 0) ? 1 : $this->getIdentityMatrix($countIpr) - $countIpr;
            $fixedFdr = ($countFdr == 0) ? 1 : $this->getIdentityMatrix($countFdr) - $countFdr;

            $arrNpf[] = $fixedNpf;
            $arrCar[] = $fixedCar;
            $arrIpr[] = $fixedIpr;
            $arrFdr[] = $fixedFdr;
        }
        
        $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);

        $matrix_reorder = [];

        foreach ($mergeMatrix as $key => $value) {
            $matrix_reorder[$key] = [$arrNpf[$key], $arrCar[$key], $arrIpr[$key],  $arrFdr[$key]];
        }
 
        // dd($matrix_reorder);
        /* End get normalized data */
        $invMatrixValues = Excel::MINVERSE($matrix_reorder);

        //dump($invMatrixValues);

        $table = '<tbody id="tbodyVariable">';
        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[0][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[0][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[0][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[0][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[1][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[1][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[1][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[1][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[2][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[2][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[2][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[2][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[3][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[3][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[3][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($invMatrixValues[3][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '</tbody>';

        return $table;
    }

    public function totalRelationMatrix()
    {
        $variable = ['NPF','CAR','IPR','FDR'];

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
        $arrNpf = array();
        $arrCar = array();
        $arrIpr = array();
        $arrFdr = array();
        $normal_npf = [];
        $normal_car = [];
        $normal_ipr = [];
        $normal_fdr = [];
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $countNpf = $valNpf / $totalMatrix['arrTotal'];
            $countCar = $valCar / $totalMatrix['arrTotal'];
            $countIpr = $valIpr / $totalMatrix['arrTotal'];
            $countFdr = $valFdr / $totalMatrix['arrTotal'];

            $normal_npf[] = $countNpf ;
        $normal_car[] = $countCar ;
        $normal_ipr[] =  $countIpr ;
        $normal_fdr[] = $countFdr ;

            $fixedNpf = ($countNpf == 0) ? 1 : $this->getIdentityMatrix($countNpf) - $countNpf;
            $fixedCar = ($countCar == 0) ? 1 : $this->getIdentityMatrix($countCar) - $countCar;
            $fixedIpr = ($countIpr == 0) ? 1 : $this->getIdentityMatrix($countIpr) - $countIpr;
            $fixedFdr = ($countFdr == 0) ? 1 : $this->getIdentityMatrix($countFdr) - $countFdr;

            $arrNpf[] = $fixedNpf;
            $arrCar[] = $fixedCar;
            $arrIpr[] = $fixedIpr;
            $arrFdr[] = $fixedFdr;
        }
        
        $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);

        $matrix_reorder = [];
        $normal_matrix = [];

        foreach ($mergeMatrix as $key => $value) {
            $matrix_reorder[$key] = [$arrNpf[$key], $arrCar[$key], $arrIpr[$key],  $arrFdr[$key]];
            $normal_matrix[$key] = [$normal_npf[$key], $normal_car[$key], $normal_ipr[$key],  $normal_fdr[$key]];
        }
 
        // dd($matrix_reorder);
        /* End get normalized data */
        $invMatrixValues = Excel::MINVERSE($matrix_reorder);

        $mmultValue = Excel::MMULT($invMatrixValues, $normal_matrix);


        $mmultNpf = array_sum([
                $mmultValue[0][0],
                $mmultValue[1][0],
                $mmultValue[2][0],
                $mmultValue[3][0],
        ]);
        

        $mmultCar = array_sum([
            $mmultValue[0][1],
            $mmultValue[1][1],
            $mmultValue[2][1],
            $mmultValue[3][1],
    ]);

        $mmultIpr = array_sum([
            $mmultValue[0][2],
            $mmultValue[1][2],
            $mmultValue[2][2],
            $mmultValue[3][2],
    ]);

        $mmultFdr = array_sum([
            $mmultValue[0][3],
            $mmultValue[1][3],
            $mmultValue[2][3],
            $mmultValue[3][3],
    ]);


        $table = '<div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4">';
        $table.= '<table class="w-full text-sm text-left text-center border-collapse" >';
        $table.= '<tbody id="tbodyVariable">';
        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '</tbody>';
        $table.= '</table>';
        $table.= '</div>';

        $table.= '<p class="mb-6 text-left text-lg font-normal lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">CI hasil penjumlahan</p>';
        $table.= '<div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">';
        $table.= '<table class="w-full text-sm text-left text-center border-collapse" >';
        $table.= '<thead class="text-xs uppercase bg-gray-200" id="theadVariable">';
        $table.= '<th scope="col" class="py-3 px-6">'.number_format($mmultNpf, 2).'</th>';
        $table.= '<th scope="col" class="py-3 px-6">'.number_format($mmultCar, 2).'</th>';
        $table.= '<th scope="col" class="py-3 px-6">'.number_format($mmultIpr, 2).'</th>';
        $table.= '<th scope="col" class="py-3 px-6">'.number_format($mmultFdr, 2).'</th>';
        $table.= '</thead>';
        $table.= '</table>';
        $table.= '</div>';

        return $table;
    }

    public function matrix()
    {
        $variable = ['NPF','CAR','IPR','FDR'];

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
        $arrNpf = array();
        $arrCar = array();
        $arrIpr = array();
        $arrFdr = array();
        $normal_npf = [];
        $normal_car = [];
        $normal_ipr = [];
        $normal_fdr = [];
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $countNpf = $valNpf / $totalMatrix['arrTotal'];
            $countCar = $valCar / $totalMatrix['arrTotal'];
            $countIpr = $valIpr / $totalMatrix['arrTotal'];
            $countFdr = $valFdr / $totalMatrix['arrTotal'];

            $normal_npf[] = $countNpf ;
        $normal_car[] = $countCar ;
        $normal_ipr[] =  $countIpr ;
        $normal_fdr[] = $countFdr ;

            $fixedNpf = ($countNpf == 0) ? 1 : $this->getIdentityMatrix($countNpf) - $countNpf;
            $fixedCar = ($countCar == 0) ? 1 : $this->getIdentityMatrix($countCar) - $countCar;
            $fixedIpr = ($countIpr == 0) ? 1 : $this->getIdentityMatrix($countIpr) - $countIpr;
            $fixedFdr = ($countFdr == 0) ? 1 : $this->getIdentityMatrix($countFdr) - $countFdr;

            $arrNpf[] = $fixedNpf;
            $arrCar[] = $fixedCar;
            $arrIpr[] = $fixedIpr;
            $arrFdr[] = $fixedFdr;
        }
        
        $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);

        $matrix_reorder = [];
        $normal_matrix = [];

        foreach ($mergeMatrix as $key => $value) {
            $matrix_reorder[$key] = [$arrNpf[$key], $arrCar[$key], $arrIpr[$key],  $arrFdr[$key]];
            $normal_matrix[$key] = [$normal_npf[$key], $normal_car[$key], $normal_ipr[$key],  $normal_fdr[$key]];
        }
 
        // dd($matrix_reorder);
        /* End get normalized data */
        $invMatrixValues = Excel::MINVERSE($matrix_reorder);

        $mmultValue = Excel::MMULT($invMatrixValues, $normal_matrix);


        $table = '<div class="overflow-x-auto relative shadow-md sm:rounded-lg mb-4">';
        $table.= '<table class="w-full text-sm text-left text-center border-collapse" >';
        $table.= '<tbody id="tbodyVariable">';
        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[0][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[1][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[2][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][0], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][1], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][2], 2).'</td>';
        $table.= '<td class="border py-4 px-6">'.number_format($mmultValue[3][3], 2).'</td>';
        $table.= '</tr>';

        $table.= '</tbody>';
        $table.= '</table>';
        $table.= '</div>';

        return $table;
    }

    public function averageTreshold()
    {
        $variable = ['NPF','CAR','IPR','FDR'];

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
        $arrNpf = array();
        $arrCar = array();
        $arrIpr = array();
        $arrFdr = array();
        $normal_npf = [];
        $normal_car = [];
        $normal_ipr = [];
        $normal_fdr = [];
        foreach ($variable as $item) {
            $valNpf = ($item == $variable[0]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[0]);
            $valCar = ($item == $variable[1]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[1]);
            $valIpr = ($item == $variable[2]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[2]);
            $valFdr = ($item == $variable[3]) ? 0: $this->getProb($item.' Does not Granger Cause '.$variable[3]);

            $countNpf = $valNpf / $totalMatrix['arrTotal'];
            $countCar = $valCar / $totalMatrix['arrTotal'];
            $countIpr = $valIpr / $totalMatrix['arrTotal'];
            $countFdr = $valFdr / $totalMatrix['arrTotal'];

            $normal_npf[] = $countNpf ;
        $normal_car[] = $countCar ;
        $normal_ipr[] =  $countIpr ;
        $normal_fdr[] = $countFdr ;

            $fixedNpf = ($countNpf == 0) ? 1 : $this->getIdentityMatrix($countNpf) - $countNpf;
            $fixedCar = ($countCar == 0) ? 1 : $this->getIdentityMatrix($countCar) - $countCar;
            $fixedIpr = ($countIpr == 0) ? 1 : $this->getIdentityMatrix($countIpr) - $countIpr;
            $fixedFdr = ($countFdr == 0) ? 1 : $this->getIdentityMatrix($countFdr) - $countFdr;

            $arrNpf[] = $fixedNpf;
            $arrCar[] = $fixedCar;
            $arrIpr[] = $fixedIpr;
            $arrFdr[] = $fixedFdr;
        }
        
        $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);

        $matrix_reorder = [];
        $normal_matrix = [];

        foreach ($mergeMatrix as $key => $value) {
            $matrix_reorder[$key] = [$arrNpf[$key], $arrCar[$key], $arrIpr[$key],  $arrFdr[$key]];
            $normal_matrix[$key] = [$normal_npf[$key], $normal_car[$key], $normal_ipr[$key],  $normal_fdr[$key]];
        }
 
        // dd($matrix_reorder);
        /* End get normalized data */
        $invMatrixValues = Excel::MINVERSE($matrix_reorder);

        $mmultValue = Excel::MMULT($invMatrixValues, $normal_matrix);
        $avg =  Excel::Average($mmultValue);
        AdditionalData::updateOrCreate([
            'name' => 'average_treshold',
            'negara_masters_id' => 1,
            'jenis' => 'a'
        ],[
            'value' => $avg
        ]);

        $table = '<div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-4">';
        $table.= '<table class="w-full text-sm text-left text-center border-collapse" >';
        $table.= '<thead class="text-xs uppercase bg-gray-200" id="theadVariable">';
        $table.= '<th scope="col" class="py-3 px-6">Average</th>';
        $table.= '<th scope="col" class="py-3 px-6">'.number_format($avg, 2).'</th>';
        $table.= '</thead>';
        $table.= '</table>';
        $table.= '</div>';

        return $table;
    }
}
