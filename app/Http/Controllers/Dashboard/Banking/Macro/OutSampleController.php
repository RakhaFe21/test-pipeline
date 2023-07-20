<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\VariableMaster;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class OutSampleController extends Controller
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
    public function indexUpper(Request $request)
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->groupBy('tahun')
        ->get()
        ->toArray();
        
        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [1,2,3,4,5])
            ->get()
            ->toArray();

        return view('dashboard.bank.macro.ews.upper.index', compact('tahun', 'variable'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLower(Request $request)
    {
        $tahun = VariableData::select('tahun', 'negara_masters_id')
        ->where('negara_masters_id', $this->country->id)
        ->groupBy('tahun')
        ->get()
        ->toArray();
        
        $variable = VariableMaster::select('nama_variable', 'id')
            ->whereNotIn('id', [1,2,3,4,5])
            ->get()
            ->toArray();

        return view('dashboard.bank.macro.ews.lower.index', compact('tahun', 'variable'));
    }

    public function signalData(Request $request)
    {       
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg =$avg->value;
            if(!empty($request->variable)) {

                /* get total signal */
                $signal = VariableData::where('variable_masters_id', $request->variable)->where('negara_masters_id', $this->country->id)->get()->toArray();

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
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function signalDataLower(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg = -$avg->value;
            if(!empty($request->variable)) {

                 /* get total signal */
                 $signal = VariableData::where('variable_masters_id', $request->variable)->where('negara_masters_id', $this->country->id)->get()->toArray();

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

    
}
