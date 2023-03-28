<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use mysql_xdevapi\Exception;
use Phpml\Math\Matrix;

class SignalingTresholdController extends Controller
{
    /**
     * Display a listing of the resource upper.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('variable_masters_id', '!=', 5)
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();

        return view('dashboard.bank.ibri.signaling.upper.index', compact('tahun'));
    }

    public function dataUpper(Request $request)
    {
        try {
            if(!empty($request->periode)) {

                $variable = ['NPF','CAR','IPR','FDR'];

                /*
                 * Get matrix max
                 * */
                $totalMatrix = array();
                foreach ($variable as $item) {
                    $valNpf = ($item == $variable[0]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[0]);
                    $valCar = ($item == $variable[1]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[1]);
                    $valIpr = ($item == $variable[2]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[2]);
                    $valFdr = ($item == $variable[3]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[3]);

                    /* Get sum of matrix */
                    $sumAll = $valNpf + $valCar + $valIpr + $valFdr;
                    $totalMatrix['arrTotal'] = $sumAll;
                }
                /* End get matrix max */

                /*
                 * Get normalized data
                 * */
                $npfNormalized = array();
                $carNormalized = array();
                $iprNormalized = array();
                $fdrNormalized = array();

                $arrNpf = array();
                $arrCar = array();
                $arrIpr = array();
                $arrFdr = array();

                $sumNpf = 0;
                foreach ($variable as $item) {
                    $valNpf = ($item == $variable[0]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[0]);
                    $valCar = ($item == $variable[1]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[1]);
                    $valIpr = ($item == $variable[2]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[2]);
                    $valFdr = ($item == $variable[3]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[3]);

                    $countNpf = $valNpf / $totalMatrix['arrTotal'];
                    $countCar = $valCar / $totalMatrix['arrTotal'];
                    $countIpr = $valIpr / $totalMatrix['arrTotal'];
                    $countFdr = $valFdr / $totalMatrix['arrTotal'];

                    $fixedNpf = ($countNpf == 0) ? 0 : number_format($countNpf, 2);
                    $fixedCar = ($countCar == 0) ? 0 : number_format($countCar, 2);
                    $fixedIpr = ($countIpr == 0) ? 0 : number_format($countIpr, 2);
                    $fixedFdr = ($countFdr == 0) ? 0 : number_format($countFdr, 2);

                    $matrixIdentityNpf = ($countNpf == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countNpf, 2)) - number_format($countNpf, 2);
                    $matrixIdentityCar = ($countCar == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countCar, 2)) - number_format($countCar, 2);
                    $matrixIdentityIpr = ($countIpr == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countIpr, 2)) - number_format($countIpr, 2);
                    $matrixIdentityFdr = ($countFdr == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countFdr, 2)) - number_format($countFdr, 2);

                    $npfNormalized[] = $fixedNpf;
                    $carNormalized[] = $fixedCar;
                    $iprNormalized[] = $fixedIpr;
                    $fdrNormalized[] = $fixedFdr;

                    $arrNpf[] = $matrixIdentityNpf;
                    $arrCar[] = $matrixIdentityCar;
                    $arrIpr[] = $matrixIdentityIpr;
                    $arrFdr[] = $matrixIdentityFdr;

                    $sumNpf+= $matrixIdentityNpf;
                }

                $allNormalized = array($npfNormalized, $carNormalized, $iprNormalized, $fdrNormalized);
                $normMatrix = new Matrix($allNormalized);
                $normMatrixValues = $normMatrix->inverse();

                //dump($allNormalized);

                $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);
                $invMatrix = new Matrix($mergeMatrix);
                /* End get normalized data */

                $invMatrixValues = $invMatrix->inverse();

                $mmultValue = $normMatrixValues->multiply($invMatrixValues)->toArray();

                $mmultNpf = array_sum(array_filter($mmultValue[0], function ($num){
                    return $num > 0;
                }));

                $mmultCar = array_sum(array_filter($mmultValue[1], function ($num){
                    return $num > 0;
                }));

                $mmultIpr = array_sum(array_filter($mmultValue[2], function ($num){
                    return $num > 0;
                }));

                $mmultFdr = array_sum(array_filter($mmultValue[3], function ($num){
                    return $num > 0;
                }));

                $arrData = array(
                    $mmultValue[0][0],
                    $mmultValue[1][0],
                    $mmultValue[2][0],
                    $mmultValue[3][0],
                    $mmultValue[0][1],
                    $mmultValue[1][1],
                    $mmultValue[2][1],
                    $mmultValue[3][1],
                    $mmultValue[0][2],
                    $mmultValue[1][2],
                    $mmultValue[2][2],
                    $mmultValue[3][2],
                    $mmultValue[0][3],
                    $mmultValue[1][3],
                    $mmultValue[2][3],
                    $mmultValue[3][3]
                );

                $avg =  number_format(array_sum($arrData)/count($arrData), 2);

                $key = explode("-", $request->periode);
                $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                    ->when($key, function ($query, $key) {
                        $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                    })->orderBy('bulan', 'asc')->get();

                $varData = VariableData::selectRaw('tahun')
                    ->where('variable_masters_id', $key[1])
                    ->havingRaw('count(bulan) = 12')
                    ->groupBy('tahun')
                    ->orderBy('tahun', 'desc')
                    ->limit(1)
                    ->first();

                $devData = VariableData::where(['tahun' => $varData->tahun, 'variable_masters_id' => $key[1]])->get();

                $indexArray = array();
                foreach ($devData as $v) {
                    $totalIndex[] = $v->value_index;
                }

                $ar = array_filter($totalIndex);
                $average = number_format(array_sum($totalIndex)/count($ar), 2);

                $stDev = number_format($this->stDev($totalIndex), 2);

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $key[1])->get();

                return ['code' => 200, 'message' => 'success', 'data' => $data, 'average' => $avg, 'stdev' => $stDev, 'averageSignaling' => $average, 'varName' => $key[2], 'signal' => $signal];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function dataLower(Request $request)
    {
        try {
            if(!empty($request->periode)) {

                $variable = ['NPF','CAR','IPR','FDR'];

                /*
                 * Get matrix max
                 * */
                $totalMatrix = array();
                foreach ($variable as $item) {
                    $valNpf = ($item == $variable[0]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[0]);
                    $valCar = ($item == $variable[1]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[1]);
                    $valIpr = ($item == $variable[2]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[2]);
                    $valFdr = ($item == $variable[3]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[3]);

                    /* Get sum of matrix */
                    $sumAll = $valNpf + $valCar + $valIpr + $valFdr;
                    $totalMatrix['arrTotal'] = $sumAll;
                }
                /* End get matrix max */

                /*
                 * Get normalized data
                 * */
                $npfNormalized = array();
                $carNormalized = array();
                $iprNormalized = array();
                $fdrNormalized = array();

                $arrNpf = array();
                $arrCar = array();
                $arrIpr = array();
                $arrFdr = array();

                $sumNpf = 0;
                foreach ($variable as $item) {
                    $valNpf = ($item == $variable[0]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[0]);
                    $valCar = ($item == $variable[1]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[1]);
                    $valIpr = ($item == $variable[2]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[2]);
                    $valFdr = ($item == $variable[3]) ? 0: app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getProb($item.' Does not Granger Cause '.$variable[3]);

                    $countNpf = $valNpf / $totalMatrix['arrTotal'];
                    $countCar = $valCar / $totalMatrix['arrTotal'];
                    $countIpr = $valIpr / $totalMatrix['arrTotal'];
                    $countFdr = $valFdr / $totalMatrix['arrTotal'];

                    $fixedNpf = ($countNpf == 0) ? 0 : number_format($countNpf, 2);
                    $fixedCar = ($countCar == 0) ? 0 : number_format($countCar, 2);
                    $fixedIpr = ($countIpr == 0) ? 0 : number_format($countIpr, 2);
                    $fixedFdr = ($countFdr == 0) ? 0 : number_format($countFdr, 2);

                    $matrixIdentityNpf = ($countNpf == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countNpf, 2)) - number_format($countNpf, 2);
                    $matrixIdentityCar = ($countCar == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countCar, 2)) - number_format($countCar, 2);
                    $matrixIdentityIpr = ($countIpr == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countIpr, 2)) - number_format($countIpr, 2);
                    $matrixIdentityFdr = ($countFdr == 0) ? 1 : app(\App\Http\Controllers\Dashboard\Banking\Ibri\NullHypothesisDataController::class)->getIdentityMatrix(number_format($countFdr, 2)) - number_format($countFdr, 2);

                    $npfNormalized[] = $fixedNpf;
                    $carNormalized[] = $fixedCar;
                    $iprNormalized[] = $fixedIpr;
                    $fdrNormalized[] = $fixedFdr;

                    $arrNpf[] = $matrixIdentityNpf;
                    $arrCar[] = $matrixIdentityCar;
                    $arrIpr[] = $matrixIdentityIpr;
                    $arrFdr[] = $matrixIdentityFdr;

                    $sumNpf+= $matrixIdentityNpf;
                }

                $allNormalized = array($npfNormalized, $carNormalized, $iprNormalized, $fdrNormalized);
                $normMatrix = new Matrix($allNormalized);
                $normMatrixValues = $normMatrix->inverse();

                //dump($allNormalized);

                $mergeMatrix = array($arrNpf, $arrCar, $arrIpr, $arrFdr);
                $invMatrix = new Matrix($mergeMatrix);
                /* End get normalized data */

                $invMatrixValues = $invMatrix->inverse();

                $mmultValue = $normMatrixValues->multiply($invMatrixValues)->toArray();

                $mmultNpf = array_sum(array_filter($mmultValue[0], function ($num){
                    return $num > 0;
                }));

                $mmultCar = array_sum(array_filter($mmultValue[1], function ($num){
                    return $num > 0;
                }));

                $mmultIpr = array_sum(array_filter($mmultValue[2], function ($num){
                    return $num > 0;
                }));

                $mmultFdr = array_sum(array_filter($mmultValue[3], function ($num){
                    return $num > 0;
                }));

                $arrData = array(
                    $mmultValue[0][0],
                    $mmultValue[1][0],
                    $mmultValue[2][0],
                    $mmultValue[3][0],
                    $mmultValue[0][1],
                    $mmultValue[1][1],
                    $mmultValue[2][1],
                    $mmultValue[3][1],
                    $mmultValue[0][2],
                    $mmultValue[1][2],
                    $mmultValue[2][2],
                    $mmultValue[3][2],
                    $mmultValue[0][3],
                    $mmultValue[1][3],
                    $mmultValue[2][3],
                    $mmultValue[3][3]
                );

                $avg =  number_format(array_sum($arrData)/count($arrData), 2);

                $key = explode("-", $request->periode);
                $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                    ->when($key, function ($query, $key) {
                        $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                    })->orderBy('bulan', 'asc')->get();

                $varData = VariableData::selectRaw('tahun')
                    ->where('variable_masters_id', $key[1])
                    ->havingRaw('count(bulan) = 12')
                    ->groupBy('tahun')
                    ->orderBy('tahun', 'desc')
                    ->limit(1)
                    ->first();

                $devData = VariableData::where(['tahun' => $varData->tahun, 'variable_masters_id' => $key[1]])->get();

                $indexArray = array();
                foreach ($devData as $v) {
                    $totalIndex[] = $v->value_index;
                }

                $ar = array_filter($totalIndex);
                $average = number_format(array_sum($totalIndex)/count($ar), 2);

                $stDev = number_format($this->stDev($totalIndex), 2);

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $key[1])->get();

                return ['code' => 200, 'message' => 'success', 'data' => $data, 'average' => -$avg, 'stdev' => $stDev, 'averageSignaling' => $average, 'varName' => $key[2], 'signal' => $signal];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    private function stDev($aValues, $bSample = false)
    {
        $fMean = array_sum($aValues) / count($aValues);
        $fVariance = 0.0;
        foreach ($aValues as $i)
        {
            $fVariance += pow($i - $fMean, 2);
        }
        $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
        return (float) sqrt($fVariance);
    }

    /**
     * Display a listing of the resource lower.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLower()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('variable_masters_id', '!=', 5)
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();

        return view('dashboard.bank.ibri.signaling.lower.index', compact('tahun'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
