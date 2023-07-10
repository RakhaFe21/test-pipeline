<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class SignalingTresholdController extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    /**
     * Display a listing of the resource upper.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable', 'negara_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->whereNotIn('variable_masters_id',[1,2,3,4,5])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();

        return view('dashboard.bank.macro.signaling.upper.index', compact('tahun'));
    }

    public function dataUpper(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg = $avg->value;
            // Check if request is CI
            if(!empty($request->periode)) {
                $key = explode("-", $request->periode);

                $devData = VariableData::where(['tahun' => $key[0], 'variable_masters_id' => $key[1], 'negara_masters_id' => $this->country->id])->get();
                foreach ($devData as $v) {
                    $totalIndex[] = $v->value_index;
                }

                $ar = array_filter($totalIndex);
                $average = number_format(array_sum($totalIndex)/count($ar), 2);

                $stDev = number_format($this->stDev($totalIndex), 2);

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $key[1])->where('negara_masters_id', $this->country->id)->get();

                return ['code' => 200, 'message' => 'success', 'data' => $devData, 'average' => round($avg, 2), 'stdev' => $stDev, 'averageSignaling' => $average, 'varName' => $key[2], 'signal' => $signal];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function dataLower(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg =$avg->value;
            if(!empty($request->periode)) {

                $key = explode("-", $request->periode);
                $devData = VariableData::where(['tahun' => $key[0], 'variable_masters_id' => $key[1], 'negara_masters_id' => $this->country->id])->get();

                $indexArray = array();
                foreach ($devData as $v) {
                    $totalIndex[] = $v->value_index;
                }

                $ar = array_filter($totalIndex);
                $average = number_format(array_sum($totalIndex)/count($ar), 2);

                $stDev = number_format($this->stDev($totalIndex), 2);

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $key[1])->where('negara_masters_id', $this->country->id)->get();

                return ['code' => 200, 'message' => 'success', 'data' => $devData, 'average' => -(round($avg, 2)), 'stdev' => $stDev, 'averageSignaling' => $average, 'varName' => $key[2], 'signal' => $signal];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (\Exception $e) {
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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable', 'negara_masters_id')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id',[1,2,3,4,5])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();

        return view('dashboard.bank.macro.signaling.lower.index', compact('tahun'));
    }

}
