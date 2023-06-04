<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\VariableMaster;
use App\Models\AdditionalData;
use App\Models\VariableWeight;
use mysql_xdevapi\Exception;
use Phpml\Math\Matrix;

class OutSampleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUpper(Request $request)
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get()
            ->toArray();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();

        return view('dashboard.bank.ibri.ews.upper.index', compact('tahun', 'variable'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLower(Request $request)
    {
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get()
            ->toArray();

        $variable = VariableMaster::select('nama_variable', 'id')
            ->get()
            ->toArray();

        return view('dashboard.bank.ibri.ews.lower.index', compact('tahun', 'variable'));
    }

    public function signalData(Request $request)
    {       
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', '1'],
                ['jenis' , '=', 'a']
            ])->first();
            $avg =$avg->value;
            if(!empty($request->variable)) {

                // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                //     ->when($request, function ($query, $request) {
                //         $query->where(['tahun' => $request->tahun, 'variable_masters_id' => $request->variable]);
                //     })->orderBy('bulan', 'asc')->get()->toArray();

                // $varData = VariableData::selectRaw('tahun')
                //     ->where('variable_masters_id', $request->variable)
                //     ->havingRaw('count(bulan) = 12')
                //     ->groupBy('tahun')
                //     ->orderBy('tahun', 'desc')
                //     ->limit(1)
                //     ->first();

                // $devData = VariableData::where(['tahun' => $varData->tahun, 'variable_masters_id' => $request->variable])->get();

                // $indexArray = array();
                // foreach ($devData as $v) {
                //     $totalIndex[] = $v->value_index;
                // }

                // $ar = array_filter($totalIndex);
                // $average = number_format(array_sum($totalIndex)/count($ar), 2);

                // $stDev = number_format($this->stDev($totalIndex), 2);

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $request->variable)->get()->toArray();

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
                            $dt['tahun'] = $val['tahun'];
                            $dt['bulan'] = $val['bulan'];
                            $dt['value_index'] = $val['value_index'];
                            $dt['average'] = $avg;
                            $dt['hp'] = $v;
                            $dt['signal'] = ($v > $avg)?1:0;
                            $dt['signal_crisis'] = ($val['value_index'] > $avg)?1:0;
                            $hpDt[] = $dt;
                        }
                    }
                }

                return ['code' => 200, 'message' => 'success', 'average' => $avg, 'data' => $hpDt];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function signalDataLower(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', '1'],
                ['jenis' , '=', 'a']
            ])->first();
            $avg = -$avg->value;
            if(!empty($request->variable)) {

               
                // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                //     ->when($request, function ($query, $request) {
                //         $query->where(['tahun' => $request->tahun, 'variable_masters_id' => $request->variable]);
                //     })->orderBy('bulan', 'asc')->get()->toArray();

                // $varData = VariableData::selectRaw('tahun')
                //     ->where('variable_masters_id', $request->variable)
                //     ->havingRaw('count(bulan) = 12')
                //     ->groupBy('tahun')
                //     ->orderBy('tahun', 'desc')
                //     ->limit(1)
                //     ->first();

                // $devData = VariableData::where(['tahun' => $varData->tahun, 'variable_masters_id' => $request->variable])->get();

                // $indexArray = array();
                // foreach ($devData as $v) {
                //     $totalIndex[] = $v->value_index;
                // }

                 /* get total signal */
                 $signal = VariableData::where('variable_masters_id', $request->variable)->get()->toArray();

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
                            $dt['tahun'] = $val['tahun'];
                            $dt['bulan'] = $val['bulan'];
                            $dt['value_index'] = $val['value_index'];
                            $dt['average'] = $avg;
                            $dt['hp'] = $v;
                            $dt['signal'] = ($v < $avg)?1:0;
                            $dt['signal_crisis'] = ($val['value_index'] < $avg)?1:0;
                            $hpDt[] = $dt;
                        }
                    }
                }

                return ['code' => 200, 'message' => 'success', 'average' => $avg, 'data' => $hpDt];
            } else {
                return ['code' => 500, 'message' => 'Silahkan pilih periode', 'data' => ''];
            }
        } catch (Exception $e) {
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
