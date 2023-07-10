<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\VariableWeight;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use mysql_xdevapi\Exception;
use Phpml\Math\Matrix;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            // ->where('variable_masters_id', '!=', 5)
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
        return view('dashboard.bank.ibri.sample.upper.index', compact('tahun'));
    }

    public function dataUpper(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'a']
            ])->first();
            $avg =$avg->value;
            if(!empty($request->periode)) {
                $explode_req = explode("-", $request->periode);
                
                $key = explode("-", $request->periode);
                // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                //     ->when($key, function ($query, $key) {
                //         $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                //     })->orderBy('bulan', 'asc')->get()->each(function ($collection, $alphabet) {
                //         $collection->value_index = $collection->value;
                //     })->toArray();

                // $varData = VariableData::selectRaw('tahun')
                //     ->where('variable_masters_id', $key[1])
                //     ->havingRaw('count(bulan) = 12')
                //     ->groupBy('tahun')
                //     ->orderBy('tahun', 'desc')
                //     ->limit(1)
                //     ->first();

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
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'a']
            ])->first();
            $avg = $avg->value;
            if(!empty($request->periode)) {
                if(!empty($request->periode)) {
                    $explode_req = explode("-", $request->periode);
                    
                    $key = explode("-", $request->periode);
                    // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                    //     ->when($key, function ($query, $key) {
                    //         $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                    //     })->orderBy('bulan', 'asc')->get()->each(function ($collection, $alphabet) {
                    //         $collection->value_index = $collection->value;
                    //     })->toArray();
    
                    // $varData = VariableData::selectRaw('tahun')
                    //     ->where('variable_masters_id', $key[1])
                    //     ->havingRaw('count(bulan) = 12')
                    //     ->groupBy('tahun')
                    //     ->orderBy('tahun', 'desc')
                    //     ->limit(1)
                    //     ->first();
    
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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            // ->where('variable_masters_id', '!=', 5)
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();
        return view('dashboard.bank.ibri.sample.lower.index', compact('tahun'));
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
