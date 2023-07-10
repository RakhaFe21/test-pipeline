<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\SpreadsheetServiceController as Excel;
use App\Http\Controllers\Service\IndexBServiceController;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class BankTransformingController extends Controller
{

    private string $code;

    public function __construct()
    {
        $country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$country) {
            return abort(500, 'Something went wrong');
        }
        $this->code = $country->id;
    }
    public function index()
    {
        (new IndexBServiceController)->transform_to_index();
        $tahun = VariableData::select('tahun', 'negara_masters_id')
        ->where('negara_masters_id', $this->code)
            ->groupBy('tahun')
            ->get();

        $master = VariableData::select('tahun', 'bulan', 'value', 'variable_masters_id', 'negara_masters_id')
        ->where('negara_masters_id', $this->code)
            ->where('variable_masters_id', '!=', 1)
            ->where('variable_masters_id', '!=', 2)
            ->where('variable_masters_id', '!=', 3)
            ->where('variable_masters_id', '!=', 4)
            ->where('variable_masters_id', '!=', 5)
            ->where('variable_masters_id', '!=', 10)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->get();

           if (!$master->isEmpty()) {
            $grouped = $master->groupBy('variable_masters_id')->transform(function($item, $k) {
                return $item->groupBy('tahun');
            });
            $grouped = $grouped->all();
            $arr = [];
            
            //array grouped
            foreach ($grouped as $key => $tahun) {
                $temp_id = [];
                foreach ($tahun as $keyTahun => $items) {
                    $temp_item = [];
                    foreach ($items as $keyItem => $item) {
                        $temp_item[] = $item->value;
                    }
                    array_push($temp_id, $temp_item);
                }
                array_push($arr, $temp_id);
            }

            //array stdev
            $result_stdev = [];
            foreach ($arr as $key => $index) {
                $temp_stdev = [];
                foreach ($index as $keyTahun => $items) {
                    $result = Excel::STDEV($items);
                    array_push($temp_stdev, $result);
                }
                array_push($result_stdev, $temp_stdev);
            }

            $min_gpd = min($result_stdev[0]);
            $min_inf = min($result_stdev[1]);
            $min_er = min($result_stdev[2]);
            $min_jii = min($result_stdev[3]);

            $result_mean = [];
            foreach ($arr as $key => $indexx) {
                $temp_mean = [];
                foreach ($indexx as $keyTahun => $items) {
                    $result = Excel::average($items);
                    array_push($temp_mean, round($result, 2));
                }
                array_push($result_mean, $temp_mean);
            } 
           }
            // dd($result_stdev);
            // $test = (4.36-3.24)/0.040;
        return view('dashboard.bank.macro.transforming.index', [
            'years'     => @$tahun ?? [],
            'stdevs'    => @$result_stdev ?? 0,
            'means'     => @$result_mean ?? 0,
            'min_gpd'   => @$min_gpd ?? 0,
            'min_inf'   => @$min_inf ?? 0,
            'min_er'   => @$min_er ?? 0,
            'min_jii'   => @$min_jii ?? 0
        ]);
    }

}
