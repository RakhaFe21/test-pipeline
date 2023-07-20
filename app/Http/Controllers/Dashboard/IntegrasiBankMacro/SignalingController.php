<?php

namespace App\Http\Controllers\Dashboard\IntegrasiBankMacro;

use App\Http\Controllers\Controller;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SignalingController extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereIn('variable_masters_id',[5,10])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
            
        return view('dashboard.integrasi_bank_macro.signaling.upper.index', [
            'tahun' => $tahun
        ]);
    }

    public function indexLower()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereIn('variable_masters_id',[5,10])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
            
        return view('dashboard.integrasi_bank_macro.signaling.lower.index', [
            'tahun' => $tahun
        ]);
}

    public function dataUpper(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'a']
            ])->first();
            $avg1 = $avg->value;
            if(!empty($request->periode)) {
                // BANKING
                $devData1 = VariableData::where(['tahun' => $request->periode, 'variable_masters_id' => 5, 'negara_masters_id' => $this->country->id])->get();
                foreach ($devData1 as $v) {
                    $totalIndex1[] = $v->value_index;
                }

                $ar1 = array_filter($totalIndex1);
                $average1 = number_format(array_sum($totalIndex1)/count($ar1), 2);

                $stDev1 = number_format($this->stDev($totalIndex1), 2);

                /* get total signal */
                $signal1 = VariableData::where('variable_masters_id', 5)->where('variable_masters_id', $this->country->id)->get();

                //MACRO

                $avg2 =  AdditionalData::where([
                    ['name' , '=', 'average_treshold'],
                    ['negara_masters_id' , '=', $this->country->id],
                    ['jenis' , '=', 'b']
                ])->first();
                $avg2 = $avg2->value;
                $devData2 = VariableData::where(['tahun' => $request->periode, 'variable_masters_id' => 10, 'negara_masters_id' => $this->country->id])->get();
                foreach ($devData2 as $v) {
                    $totalIndex2[] = $v->value_index;
                }

                $ar2 = array_filter($totalIndex2);
                $average2 = number_format(array_sum($totalIndex2)/count($ar2), 2);

                $stDev2 = number_format($this->stDev($totalIndex2), 2);

                /* get total signal */
                $signal2 = VariableData::where('variable_masters_id', 10)->where('negara_masters_id', $this->country->id)->get();
                $arrData = [
                    [
                        'data' => $devData2, 'average' => round($avg2, 2), 'stdev' => $stDev2, 'averageSignaling' => $average2, 'signal' => $signal2
                    ],
                    [
                        'data' => $devData1, 'average' => round($avg1, 2), 'stdev' => $stDev1, 'averageSignaling' => $average1, 'signal' => $signal1
                    ]
                ];

                return ['code' => 200, 'message' => 'success', 'data' =>  $arrData];
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
                ['jenis' , '=', 'a']
            ])->first();
            $avg1 = $avg->value;
            if(!empty($request->periode)) {
                // BANKING
                $devData1 = VariableData::where(['tahun' => $request->periode, 'variable_masters_id' => 5, 'negara_masters_id' => $this->country->id])->get();
                foreach ($devData1 as $v) {
                    $totalIndex1[] = $v->value_index;
                }

                $ar1 = array_filter($totalIndex1);
                $average1 = number_format(array_sum($totalIndex1)/count($ar1), 2);

                $stDev1 = number_format($this->stDev($totalIndex1), 2);

                /* get total signal */
                $signal1 = VariableData::where('variable_masters_id', 5)->where('negara_masters_id', $this->country->id)->get();

                //MACRO

                $avg2 =  AdditionalData::where([
                    ['name' , '=', 'average_treshold'],
                    ['negara_masters_id' , '=', $this->country->id],
                    ['jenis' , '=', 'b']
                ])->first();
                $avg2 = $avg2->value;
                $devData2 = VariableData::where(['tahun' => $request->periode, 'variable_masters_id' => 10, 'negara_masters_id' => $this->country->id])->get();
                foreach ($devData2 as $v) {
                    $totalIndex2[] = $v->value_index;
                }

                $ar2 = array_filter($totalIndex2);
                $average2 = number_format(array_sum($totalIndex2)/count($ar2), 2);

                $stDev2 = number_format($this->stDev($totalIndex2), 2);

                /* get total signal */
                $signal2 = VariableData::where('variable_masters_id', 10)->where('negara_masters_id', $this->country->id)->get();
                $arrData = [
                    [
                        'data' => $devData2, 'average' => -round($avg2, 2), 'stdev' => $stDev2, 'averageSignaling' => $average2, 'signal' => $signal2
                    ],
                    [
                        'data' => $devData1, 'average' => -round($avg1, 2), 'stdev' => $stDev1, 'averageSignaling' => $average1, 'signal' => $signal1
                    ]
                ];

                return ['code' => 200, 'message' => 'success', 'data' =>  $arrData];
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
}
