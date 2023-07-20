<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class SampleModelController extends Controller
{
    private $country;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUpper()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable', 'negara_masters_id')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [1,2,3,4,5])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
        return view('dashboard.bank.macro.sample.upper.index', compact('tahun'));
    }

    public function dataUpper(Request $request)
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

                foreach ($devData as $v) {
                    $totalIndex[] = $v->value_index;
                }


                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $key[1])->where('negara_masters_id', $this->country->id)->get();

                //dump($signal);
                $aSignal = array();
                foreach ($signal as $s) {
                    $aSignal[] = $s['value_index'];
                }

                $list = implode(',', $aSignal);
                $hp = json_decode($this->getHpFilter($list));

                $hpDt = array();
                foreach ($hp->data as $k => $v) {
                    foreach ($signal as $i => $val) {
                        if($k == $i) {
                            $dt['id'] = $val['id'];
                            $dt['negara_master_id'] = $val['negara_masters_id'];
                            $dt['variable_master_id'] = $val['variable_masters_id'];
                            $dt['tahun'] = $val['tahun'];
                            $dt['bulan'] = $val['bulan'];
                            $dt['value'] = $val['value'];
                            $dt['value_index'] = $val['value_index'];
                            $dt['hp'] = $v;
                            $hpDt[] = $dt;
                        }
                    }
                }

                return ['code' => 200, 'message' => 'success', 'average' => round($avg, 2), 'varName' => $key[2], 'data' => $hpDt];
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
            if(!empty($request->periode)) {
                $avg =  AdditionalData::where([
                    ['name' , '=', 'average_treshold'],
                    ['negara_masters_id' , '=', $this->country->id],
                    ['jenis' , '=', 'b']
                ])->first();
                $avg =$avg->value;
                if(!empty($request->periode)) {
                    
                    $key = explode("-", $request->periode);
    
                    $devData = VariableData::where(['tahun' => $key[0], 'variable_masters_id' => $key[1], 'negara_masters_id' => $this->country->id])->get();
    
                    foreach ($devData as $v) {
                        $totalIndex[] = $v->value_index;
                    }
    
                    $ar = array_filter($totalIndex);
    
                    /* get total signal */
                    $signal = VariableData::where('variable_masters_id', $key[1])->where('negara_masters_id', $this->country->id)->get();
    
                    //dump($signal);
                    $aSignal = array();
                    foreach ($signal as $s) {
                        $aSignal[] = $s['value_index'];
                    }
    
                    $list = implode(',', $aSignal);
                    $hp = json_decode($this->getHpFilter($list));
    
                    $hpDt = array();
                    foreach ($hp->data as $k => $v) {
                        foreach ($signal as $i => $val) {
                            if($k == $i) {
                                $dt['id'] = $val['id'];
                                $dt['negara_master_id'] = $val['negara_masters_id'];
                                $dt['variable_master_id'] = $val['variable_masters_id'];
                                $dt['tahun'] = $val['tahun'];
                                $dt['bulan'] = $val['bulan'];
                                $dt['value'] = $val['value'];
                                $dt['value_index'] = $val['value_index'];
                                $dt['hp'] = $v;
                                $hpDt[] = $dt;
                            }
                        }
                    }

                    return ['code' => 200, 'message' => 'success', 'average' => -(round($avg, 2)), 'varName' => $key[2], 'data' => $hpDt];
                }
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function getHpFilter($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sipp.wesclic.com/get-hodrick-prescott',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                  "lambda": 14400,
                  "data": ['.$data.']
                }',
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLower()
    {
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable','negara_masters_id')
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [1,2,3,4,5])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
        return view('dashboard.bank.macro.sample.lower.index', compact('tahun'));
    }
}
