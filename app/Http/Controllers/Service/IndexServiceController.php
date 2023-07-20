<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use App\Models\VariableWeight;
use App\Http\Controllers\Service\SpreadsheetServiceController as Excel;

class IndexServiceController extends Controller
{
    public function __construct(private string $code) {
        
    }

    public function lower_value(array $datas)
    {
        $arr = [];
        foreach ($datas as $data) {
            array_push($arr, $data[0]);
        }
        $index = array_search(min($arr), $arr);
        return $datas[$index];
    }

    /**
     * @return array
     * [
     *  0   => NPF,
     *  1   => CAR,
     *  2   => IPR,
     *  3   => FDR
     * ]
     */
    public function get_data()
    {
        $master = VariableData::select('tahun', 'bulan', 'value', 'variable_masters_id', 'value_index')
            ->where('variable_masters_id', '!=', 5)
            ->where('variable_masters_id', '!=', 6)
            ->where('variable_masters_id', '!=', 7)
            ->where('variable_masters_id', '!=', 8)
            ->where('variable_masters_id', '!=', 9)
            ->where('variable_masters_id', '!=', 10)
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->orderBy('variable_masters_id', 'asc')
            ->where('negara_masters_id', $this->code)
            ->get();

        $grouped = $master->groupBy('variable_masters_id')->transform(function($item, $k) {
            return $item->groupBy('tahun');
        });
        
        return $grouped->all();
    }

    public function mapping_data_model($grouped)
    {
        $arr = [];
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

        return $arr;
    }

    public function mapping_data_model_index($grouped)
    {
        $arr = [];
        foreach ($grouped as $key => $tahun) {
            $temp_id = [];
            foreach ($tahun as $keyTahun => $items) {
                $temp_item = [];
                foreach ($items as $keyItem => $item) {
                    $temp_item[] = $item->value_index;
                }
                array_push($temp_id, $temp_item);
            }
            array_push($arr, $temp_id);
        }

        return $arr;
    }

    public function all_stdev_and_mean($datas)
    {
        $stdev = [];
        foreach ($datas as $keyTahun => $items) {
            $result[0] = Excel::STDEV($items);
            $result[1] = Excel::Average($items);
            $result[2] = $keyTahun;
            array_push($stdev, $result);
        }
        
        return $stdev;
    }

    public function value_to_index($values, $index)
    {
        $variable = ['NPF', 'CAR', 'IPR', 'FDR'];

        $model = VariableData::where('variable_masters_id', ($index+1))
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        $min = $this->lower_value($values);
        $weight = VariableWeight::where('negara_masters_id', 1)
        ->where('variable_masters_id', ($index+1))
        ->first();
        $weight->based_year = 2010 + $min[2];
        $weight->save();
        foreach ($model as $value) {
            $value->value_index = ($value->value - $min[1])/$min[0];
            $value->save();
        }

        return true;
    }

    public function transform_to_index()
    {   
        $datas = $this->get_data();
        if (!$datas) {
            return false;
        }
        $mapped = $this->mapping_data_model($datas);
        foreach ($mapped as $varKey => $var) {
            $stdev = $this->all_stdev_and_mean($var);
            $result_index = $this->value_to_index($stdev, $varKey);
        }

        $this->transform_to_weight($datas);
        $this->transform_to_composite($datas);
        return true;
    }

    public function transform_to_weight($datas)
    {
        $variable = ['NPF', 'CAR', 'IPR', 'FDR'];
        $arr = [];
        $mapped = $this->mapping_data_model_index($datas);
        foreach ($mapped as $key => $var) {
            $arr[$variable[$key]] = [];
            foreach ($var as $tahunKey => $value) {
                $arr[$variable[$key]][] = Excel::VARS($value);
            }
        }
        $arr['average_npf'] = Excel::Average($arr['NPF']);
        $arr['average_car'] = Excel::Average($arr['CAR']);
        $arr['average_ipr'] = Excel::Average($arr['IPR']);
        $arr['average_fdr'] = Excel::Average($arr['FDR']);
        $total = array_sum([
            $arr['average_npf'],
            $arr['average_car'],
            $arr['average_ipr'],
            $arr['average_fdr']
        ]);

        // update weight
        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 1)
            ->update(['weight' => ($arr['average_npf']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 2)
            ->update(['weight' => ($arr['average_car']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 3)
            ->update(['weight' => ($arr['average_ipr']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 4)
            ->update(['weight' => ($arr['average_fdr']/$total)]);
        return true;
    }

    public function transform_to_composite($mapped)
    {
        $weight_npf = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 1)
            ->first();

        $weight_car = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 2)
            ->first();

        $weight_ipr = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 3)
            ->first();

        $weight_fdr = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 4)
            ->first();

        $array_tahun = $this->get_array_tahun();
        foreach ($mapped as $varKey => $var) {
            if ($varKey == 1) {
                foreach ($var as $tahunKey => $items) {
                    foreach ($items as $key => $item) {
                        $composite = VariableData::where([
                            ['negara_masters_id', '=', 1],
                            ['variable_masters_id', '=', 5],
                            ['tahun', '=', $tahunKey],
                            ['bulan', '=', ($key+1)]
                        ])->first();
                        if ($composite) {
                            $value_npf = $mapped[$varKey][$tahunKey][$key]->value_index * $weight_npf->weight;
                            $value_car = $mapped[$varKey+1][$tahunKey][$key]->value_index * $weight_car->weight;
                            $value_ipr = $mapped[$varKey+2][$tahunKey][$key]->value_index * $weight_ipr->weight;
                            $value_fdr = $mapped[$varKey+3][$tahunKey][$key]->value_index * $weight_fdr->weight;
                            $composite->value_index = $value_npf + $value_car + $value_ipr + $value_fdr;
                            $composite->save();
                        } else {
                            $value_npf = $mapped[$varKey][$tahunKey][$key]->value_index * $weight_npf->weight;
                            $value_car = $mapped[$varKey+1][$tahunKey][$key]->value_index * $weight_car->weight;
                            $value_ipr = $mapped[$varKey+2][$tahunKey][$key]->value_index * $weight_ipr->weight;
                            $value_fdr = $mapped[$varKey+3][$tahunKey][$key]->value_index * $weight_fdr->weight;
                            $value = $value_npf + $value_car + $value_ipr + $value_fdr;
                            $composite = VariableData::create([
                                'negara_masters_id'     => 1,
                                'variable_masters_id'   => 5,
                                'tahun'                 => $tahunKey,
                                'bulan'                 => ($key+1),
                                'value_index'           => $value
                            ]);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function get_array_tahun()
    {   $arr = [];
        $tahun = VariableData::select('tahun')
            ->groupBy('tahun')
            ->get();
        foreach ($tahun as $key => $value) {
            array_push($arr, $value->tahun);
        }
        return $arr;
    }

    public function get_vars()
    {
        //get data by year
        $variable = ['NPF', 'CAR', 'IPR', 'FDR'];
        $arr = [];
        $datas = $this->get_data();
        $mapped = $this->mapping_data_model_index($datas);
        foreach ($mapped as $key => $var) {
            $arr[$variable[$key]] = [];
            foreach ($var as $tahunKey => $value) {
                $arr[$variable[$key]][] = Excel::VARS($value);
            }
        }
        $arr['average_npf'] = Excel::Average($arr['NPF']);
        $arr['average_car'] = Excel::Average($arr['CAR']);
        $arr['average_ipr'] = Excel::Average($arr['IPR']);
        $arr['average_fdr'] = Excel::Average($arr['FDR']);
        return $arr;
    }
}
