<?php

namespace App\Http\Controllers\Dashboard\IntegrasiBankMacro;

use App\Http\Controllers\Controller;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PerformanceController extends Controller
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
        $tahun = VariableData::select('tahun')
        ->whereIn('variable_masters_id',[5,10])
        ->where('negara_masters_id', $this->country->id)
        ->groupBy('tahun')
        ->get()
        ->toArray();

        return view('dashboard.integrasi_bank_macro.performance_evaluation.upper.index', compact('tahun'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexLower(Request $request)
    {
        $tahun = VariableData::select('tahun')
        ->whereIn('variable_masters_id',[5,10])
        ->where('negara_masters_id', $this->country->id)
            ->groupBy('tahun')
            ->get()
            ->toArray();


        return view('dashboard.integrasi_bank_macro.performance_evaluation.lower.index', compact('tahun' ));
    }

    public function signalData(Request $request)
    {       
        try {
            $avg1 =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg1 =$avg1->value;
                /* get total signal */
                $signal1 = VariableData::where('variable_masters_id', 10)->where('negara_masters_id', $this->country->id)->get()->toArray();


                $avg2 =  AdditionalData::where([
                    ['name' , '=', 'average_treshold'],
                    ['negara_masters_id' , '=', '1'],
                    ['jenis' , '=', 'b']
                ])->first();
                $avg2 =$avg2->value;
                    /* get total signal */
                    $signal2 = VariableData::where('variable_masters_id', 5)->where('negara_masters_id', $this->country->id)->get()->toArray();
    
                $hpDt = array();
                foreach ($signal1 as $i => $val) {
                    $dt['tahun'] = $val['tahun'];
                    $dt['bulan'] = $val['bulan'];
                    $dt['value_index'] = $val['value_index'];
                    $dt['signal'] = @($val['value_index'] > $avg1)?1:0;
                    $dt['signal_crisis'] = @($signal2[$i]['value_index'] > $avg2)?1:0;
                    $hpDt[] = $dt;
                }

                return ['code' => 200, 'message' => 'success', 'data' => $hpDt];
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }

    public function signalDataLower(Request $request)
    {
        try {
            $avg1 =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'b']
            ])->first();
            $avg1 =$avg1->value;
                /* get total signal */
                $signal1 = VariableData::where('variable_masters_id', 10)->where('negara_masters_id', $this->country->id)->get()->toArray();


                $avg2 =  AdditionalData::where([
                    ['name' , '=', 'average_treshold'],
                    ['negara_masters_id' , '=', $this->country->id],
                    ['jenis' , '=', 'b']
                ])->first();
                $avg2 =$avg2->value;
                    /* get total signal */
                    $signal2 = VariableData::where('variable_masters_id', 5)->where('negara_masters_id', $this->country->id)->get()->toArray();
    
                $hpDt = array();
                foreach ($signal1 as $i => $val) {
                    $dt['tahun'] = $val['tahun'];
                    $dt['bulan'] = $val['bulan'];
                    $dt['value_index'] = $val['value_index'];
                    $dt['signal'] = @($val['value_index'] < -$avg1)?1:0;
                    $dt['signal_crisis'] = @($signal2[$i]['value_index'] < -$avg2)?1:0;
                    $hpDt[] = $dt;
                }

                return ['code' => 200, 'message' => 'success', 'data' => $hpDt];
        } catch (\Exception $e) {
            return ['code' => 500, 'message' => $e->getMessage(), 'data' => ''];
        }
    }
}
