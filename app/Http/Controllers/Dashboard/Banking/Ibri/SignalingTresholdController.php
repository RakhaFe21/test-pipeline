<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use mysql_xdevapi\Exception;
use Phpml\Math\Matrix;
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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->where('negara_masters_id', $this->country->id)
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->whereNotIn('variable_masters_id', [6,7,8,9,10])
            ->groupBy('variable_masters_id')
            ->groupBy('tahun')
            ->get();

        return view('dashboard.bank.ibri.signaling.upper.index', compact('tahun'));
    }

    public function dataUpper(Request $request)
    {
        try {
            $avg =  AdditionalData::where([
                ['name' , '=', 'average_treshold'],
                ['negara_masters_id' , '=', $this->country->id],
                ['jenis' , '=', 'a']
            ])->first();
            $avg = $avg->value;
            // Check if request is CI
            if(!empty($request->periode)) {
                $explode_req = explode("-", $request->periode);

                $key = explode("-", $request->periode);
                // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                //     ->when($key, function ($query, $key) {
                //         $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                //     })->orderBy('bulan', 'asc')->get();

                // $varData = VariableData::selectRaw('tahun')
                //     ->where('variable_masters_id', $key[1])
                //     ->havingRaw('count(bulan) = 12')
                //     ->groupBy('tahun')
                //     ->orderBy('tahun', 'desc')
                //     ->limit(1)
                //     ->first();

                $devData = VariableData::where(['tahun' => $key[0], 'variable_masters_id' => $key[1],'negara_masters_id' => $this->country->id])->get();
                $indexArray = array();
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
                ['jenis' , '=', 'a']
            ])->first();
            $avg =$avg->value;
            if(!empty($request->periode)) {
                $explode_req = explode("-", $request->periode);

                $key = explode("-", $request->periode);
                // $data = VariableData::join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
                //     ->when($key, function ($query, $key) {
                //         $query->where(['tahun' => $key[0], 'variable_masters_id' => $key[1]]);
                //     })->orderBy('bulan', 'asc')->get();

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
        $tahun = VariableData::select('tahun', 'variable_masters_id', 'nama_variable')
            ->where('negara_masters_id', $this->country->id)
            ->join('variable_masters', 'variable_masters.id', '=', 'variable_data.variable_masters_id')
            ->whereNotIn('variable_masters_id', [6,7,8,9,10])
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
