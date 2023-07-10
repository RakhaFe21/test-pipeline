<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
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

    public function __construct()
    {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
    }
    
    public function index(Request $request)
    {

        $weights = VariableWeight::select('negara_masters_id','variable_masters.id', 'variable_masters.nama_variable', 'variable_weights.weight')
            ->join('variable_masters', 'variable_weights.variable_masters_id', '=', 'variable_masters.id')
            // ->orderBy('variable_weights.weight', 'desc')
            ->whereNotIn('variable_masters_id', [1,2,3,4])
            ->where('negara_masters_id', $this->country->id)
            ->get();

        $nilai = [1.00, 3.00, 5.00, 7.00];
        $gdp = [];
        $inf = [];
        $er = [];
        $jii = [];
        //logic begin

        //add nilai to variable weight
        $weightRanks = VariableWeight::select('negara_masters_id', 'variable_masters.id', 'variable_masters.nama_variable', 'variable_weights.weight')
        ->join('variable_masters', 'variable_weights.variable_masters_id', '=', 'variable_masters.id')
        ->whereNotIn('variable_masters_id', [1,2,3,4])
        ->where('negara_masters_id', $this->country->id)
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

                if ($weightRank->nama_variable == 'gdp') {
                    array_push($gdp,  $matrix_value);
                } elseif ($weightRank->nama_variable == 'inf') {
                    array_push($inf,  $matrix_value);
                } elseif ($weightRank->nama_variable == 'er') {
                    array_push($er,  $matrix_value);
                } else {
                    array_push($jii,  $matrix_value);
                }
            }
        }

        $total = [
            array_sum($gdp),
            array_sum($inf),
            array_sum($er),
            array_sum($jii)
        ];

        $normalized_gdp = [];
        $normalized_inf = [];
        $normalized_er = [];
        $normalized_jii = [];

        foreach ($gdp as $value_gdp) {
            array_push($normalized_gdp, ($value_gdp / $total[0]));
        }

        foreach ($inf as $value_inf) {
            array_push($normalized_inf, ($value_inf / $total[1]));
        }

        foreach ($er as $value_er) {
            array_push($normalized_er, ($value_er / $total[2]));
        }

        foreach ($jii as $value_jii) {
            array_push($normalized_jii, ($value_jii / $total[3]));
        }

        $total_normalized = [
            array_sum($normalized_gdp),
            array_sum($normalized_inf),
            array_sum($normalized_er),
            array_sum($normalized_jii)
        ];

        $count_var = count($total_normalized);
        $criteria_weight = [];
        foreach ($reorder as $keyWeightRank => $weightRank) {
            array_push($criteria_weight, (array_sum([
                $normalized_gdp[$keyWeightRank],
                $normalized_inf[$keyWeightRank],
                $normalized_er[$keyWeightRank],
                $normalized_jii[$keyWeightRank]
            ])/$count_var));
        }
        array_push($total_normalized, array_sum($criteria_weight));

        $chy_gdp = [];
        $chy_inf = [];
        $chy_er = [];
        $chy_jii = [];

        foreach ($gdp as $value_gdp) {
            array_push($chy_gdp, ($value_gdp * $criteria_weight[0]));
        }

        foreach ($inf as $value_inf) {
            array_push($chy_inf, ($value_inf * $criteria_weight[1]));
        }

        foreach ($er as $value_er) {
            array_push($chy_er, ($value_er * $criteria_weight[2]));
        }

        foreach ($jii as $value_jii) {
            array_push($chy_jii, ($value_jii * $criteria_weight[3]));
        }

        $weight_sum_value = [];
        foreach ($reorder as $keyWeightRank => $weightRank) {
            array_push($weight_sum_value, array_sum([
                $chy_gdp[$keyWeightRank],
                $chy_inf[$keyWeightRank],
                $chy_er[$keyWeightRank],
                $chy_jii[$keyWeightRank]
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
            'jenis' => 'b',
            'negara_masters_id' => $this->country->id
            ,
        ],[
            'value' => $consistency_ratio
        ]);
        }
        

        return view('dashboard.bank.macro.factoranalysis.index', compact('weights'))->with([
            'weightRank' => @$weightRanks,
            'gdp'   => @$gdp,
            'inf'   => @$inf,
            'er'   => @$er,
            'jii'   => @$jii,
            'total'   => @$total,
            'normalized_gdp'   => @$normalized_gdp,
            'normalized_inf'   => @$normalized_inf,
            'normalized_er'   => @$normalized_er,
            'normalized_jii'   => @$normalized_jii,
            'total_normalized'   => @$total_normalized,
            'criteria_weights'   => @$criteria_weight,
            'chy_gdp'   => @$chy_gdp,
            'chy_inf'   => @$chy_inf,
            'chy_er'   => @$chy_er,
            'chy_jii'   => @$chy_jii,
            'weight_sum_values'   => @$weight_sum_value,
            'ratio' => @$ratio,
            'lamda_max' => @$lamda_max,
            'ci' => @$ci,
            'ri' => @$ri,
            'consistency_ratio' => @$consistency_ratio,
            'percent'   => @$percent
        ]);
    }

}
