<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\IndexServiceController;
use App\Models\AdditionalData;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class BankFactorAnalysisController extends Controller
{
    private $country;
    private $indexService;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
        $this->indexService = new IndexServiceController($this->country->code);
    }
    
    public function index(Request $request)
    {

        $weights = VariableWeight::select('negara_masters_id','variable_masters.id', 'variable_masters.nama_variable', 'variable_weights.weight')
            ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [6,7,8,9])
            ->join('variable_masters', 'variable_weights.variable_masters_id', '=', 'variable_masters.id')
            // ->orderBy('variable_weights.weight', 'desc')
            ->get();
        // $weights->isEmpty() ? null : $weights;
        $nilai = [1.00, 3.00, 5.00, 7.00];
        $npf = [];
        $car = [];
        $ipr = [];
        $fdr = [];
        //logic begin

        //add nilai to variable weight
        $weightRanks = VariableWeight::select('negara_masters_id','variable_masters.id', 'variable_masters.nama_variable', 'variable_weights.weight')
        ->where('negara_masters_id', $this->country->id)
        ->whereNotIn('variable_masters_id', [6,7,8,9])
        ->join('variable_masters', 'variable_weights.variable_masters_id', '=', 'variable_masters.id')
        ->orderBy('variable_weights.weight', 'desc')
        ->get();
        $i = 1;

        if (!$weightRanks->isEmpty()) {
            $reorder = [];
            foreach ($weightRanks as $keyWeight => $weight) {
                $weight->nilai = $nilai[$keyWeight];
                $weight->rank = $i;
                $i++;
            }
    
            //reorder
            foreach ($weights as $keyWeight => $valWeight) {
                foreach ($weightRanks as $keyWeight => $weight) {
                    if ($valWeight->nama_variable == $weight->nama_variable) {
                        array_push($reorder, $weight);
                    }
                }
            }
    
            foreach ($reorder as $keyWeightRank => $weightRank) {
                // dd($weightRanks);
                foreach ($reorder as $keyWeightRank2 => $weightRank2) {
                    // dd($weightRank2);
                    $matrix_value = 0;
                    $get_rank = abs($weightRank->rank - $weightRank2->rank);
                    if ($weightRank->rank >= $weightRank2->rank) {
                        if ((float)$get_rank == 0) {
                            $matrix_value = $nilai[0];
                        } elseif ((float)$get_rank == 1) {
                            $matrix_value = $nilai[1];
                        } elseif ((float)$get_rank == 2) {
                            $matrix_value = $nilai[2];
                        } else {
                            $matrix_value = $nilai[3];
                        }
                    } else {
                        if ((float)$get_rank == 0) {
                            $matrix_value = 1 / (float) $nilai[0];
                        } elseif ((float)$get_rank == 1) {
                            $matrix_value = 1 / (float) $nilai[1];
                        } elseif ((float)$get_rank == 2) {
                            $matrix_value = 1 / (float) $nilai[2];
                        } else {
                            $matrix_value = 1 / (float) $nilai[3];
                        }
                    }
    
                    if ($weightRank->nama_variable == 'npf') {
                        array_push($npf,  $matrix_value);
                    } elseif ($weightRank->nama_variable == 'car') {
                        array_push($car,  $matrix_value);
                    } elseif ($weightRank->nama_variable == 'ipr') {
                        array_push($ipr,  $matrix_value);
                    } else {
                        array_push($fdr,  $matrix_value);
                    }
                }
            }
    
            $total = [
                array_sum($npf),
                array_sum($car),
                array_sum($ipr),
                array_sum($fdr)
            ];
    
            $normalized_npf = [];
            $normalized_car = [];
            $normalized_ipr = [];
            $normalized_fdr = [];
    
            foreach ($npf as $value_npf) {
                array_push($normalized_npf, ($value_npf / $total[0]));
            }
    
            foreach ($car as $value_car) {
                array_push($normalized_car, ($value_car / $total[1]));
            }
    
            foreach ($ipr as $value_ipr) {
                array_push($normalized_ipr, ($value_ipr / $total[2]));
            }
    
            foreach ($fdr as $value_fdr) {
                array_push($normalized_fdr, ($value_fdr / $total[3]));
            }
    
            $total_normalized = [
                array_sum($normalized_npf),
                array_sum($normalized_car),
                array_sum($normalized_ipr),
                array_sum($normalized_fdr)
            ];
    
            $count_var = count($total_normalized);
            $criteria_weight = [];
            foreach ($reorder as $keyWeightRank => $weightRank) {
                array_push($criteria_weight, (array_sum([
                    $normalized_npf[$keyWeightRank],
                    $normalized_car[$keyWeightRank],
                    $normalized_ipr[$keyWeightRank],
                    $normalized_fdr[$keyWeightRank]
                ])/$count_var));
            }
            array_push($total_normalized, array_sum($criteria_weight));
    
            $chy_npf = [];
            $chy_car = [];
            $chy_ipr = [];
            $chy_fdr = [];
    
            foreach ($npf as $value_npf) {
                array_push($chy_npf, ($value_npf * $criteria_weight[0]));
            }
    
            foreach ($car as $value_car) {
                array_push($chy_car, ($value_car * $criteria_weight[1]));
            }
    
            foreach ($ipr as $value_ipr) {
                array_push($chy_ipr, ($value_ipr * $criteria_weight[2]));
            }
    
            foreach ($fdr as $value_fdr) {
                array_push($chy_fdr, ($value_fdr * $criteria_weight[3]));
            }
    
            $weight_sum_value = [];
            foreach ($reorder as $keyWeightRank => $weightRank) {
                array_push($weight_sum_value, array_sum([
                    $chy_npf[$keyWeightRank],
                    $chy_car[$keyWeightRank],
                    $chy_ipr[$keyWeightRank],
                    $chy_fdr[$keyWeightRank]
                ]));
            }
    
            $ratio = [];
            foreach ($reorder as $keyWeightRank => $weightRank) {
                array_push($ratio, ($weight_sum_value[$keyWeightRank]/ $criteria_weight[$keyWeightRank]));
            }
    
            $random_index = [
                1 => 0.00,
                2 => 0.00,
                3 => 0.58,
                4 => 0.90,
                5 => 1.12,
                6 => 1.24,
                7 => 1.32,
                8 => 1.41,
            ];
    
            $lamda_max = (array_sum($ratio) / $count_var);
            $ci = ($lamda_max - 4) / (4-1) ;
            $ri = $random_index[$count_var];
            $consistency_ratio = ($ci/$ri) > 0.1 ? 0.1 : ($ci/$ri);
            $percent = round( $consistency_ratio * 100 ). '%';
    
            AdditionalData::updateOrCreate([
                'name' => 'consistency_ratio',
                'jenis' => 'a',
                'negara_masters_id' => $this->country->id
                ,
            ],[
                'value' => $consistency_ratio
            ]);
        }

        return view('dashboard.bank.ibri.factoranalysis.index', compact('weights'))->with([
            'weightRank' => @$weightRanks,
            'npf'   => @$npf,
            'car'   => @$car,
            'ipr'   => @$ipr,
            'fdr'   => @$fdr,
            'total'   => @$total,
            'normalized_npf'   => @$normalized_npf,
            'normalized_car'   => @$normalized_car,
            'normalized_ipr'   => @$normalized_ipr,
            'normalized_fdr'   => @$normalized_fdr,
            'total_normalized'   => @$total_normalized,
            'criteria_weights'   => @$criteria_weight,
            'chy_npf'   => @$chy_npf,
            'chy_car'   => @$chy_car,
            'chy_ipr'   => @$chy_ipr,
            'chy_fdr'   => @$chy_fdr,
            'weight_sum_values'   => @$weight_sum_value,
            'ratio' => @$ratio,
            'lamda_max' => @$lamda_max,
            'ci' => @$ci,
            'ri' => @$ri,
            'consistency_ratio' => @$consistency_ratio,
            'percent'   => @$percent
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'consistency_ratio' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
        }

        $select = AdditionalData::where('negara_masters_id', 1)
            ->where('name', 'consistency_ratio')
            ->where('jenis', 'a')
            ->get();

        $update = DB::transaction(function () use ($request, $select) {
            try {
                $message = '';

                if ($select->count() > 0) {
                    AdditionalData::where('negara_masters_id', 1)
                        ->where('name', 'consistency_ratio')
                        ->where('jenis', 'a')
                        ->update(['value' => $request->consistency_ratio]);

                    $message = 'Data update successfully';
                } else {
                    AdditionalData::insert(['negara_masters_id' => 1, 'name' => 'consistency_ratio', 'value' => $request->consistency_ratio, 'jenis' => 'a', 'created_at' => Carbon::now()]);

                    $message = 'Data saved successfully';
                }

                return ['code' => 200, 'message' => $message, 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => null];
            }
        });

        return response()->json($update, 200);
    }
}
