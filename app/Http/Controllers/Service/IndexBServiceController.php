<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use App\Http\Controllers\Service\SpreadsheetServiceController as Excel;

class IndexBServiceController extends Controller
{
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
     *  0   => GDP,
     *  1   => INF,
     *  2   => ER,
     *  3   => JII
     * ]
     */
    public function get_data()
    {
        $master = VariableData::select('tahun', 'bulan', 'value', 'variable_masters_id', 'value_index')
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
        $variable = ['GDP', 'INF', 'ER', 'JII'];

        $model = VariableData::where('variable_masters_id', ($index+6))
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get();

        $min = $this->lower_value($values);
        $weight = VariableWeight::where('negara_masters_id', 1)
        ->where('variable_masters_id', ($index+6))
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
        $variable = ['GDP', 'INF', 'ER', 'JII'];
        $arr = [];
        $mapped = $this->mapping_data_model_index($datas);
        foreach ($mapped as $key => $var) {
            $arr[$variable[$key]] = [];
            foreach ($var as $tahunKey => $value) {
                $arr[$variable[$key]][] = Excel::VARS($value);
            }
        }
        $arr['average_gdp'] = Excel::Average($arr['GDP']);
        $arr['average_inf'] = Excel::Average($arr['INF']);
        $arr['average_er'] = Excel::Average($arr['ER']);
        $arr['average_jii'] = Excel::Average($arr['JII']);
        $total = array_sum([
            $arr['average_gdp'],
            $arr['average_inf'],
            $arr['average_er'],
            $arr['average_jii']
        ]);

        // update weight
        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 6)
            ->update(['weight' => ($arr['average_gdp']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 7)
            ->update(['weight' => ($arr['average_inf']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 8)
            ->update(['weight' => ($arr['average_er']/$total)]);

        VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 9)
            ->update(['weight' => ($arr['average_jii']/$total)]);
        return true;
    }

    public function transform_to_composite($mapped)
    {
        $weight_gdp = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 6)
            ->first();

        $weight_inf = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 7)
            ->first();

        $weight_er = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 8)
            ->first();

        $weight_jii = VariableWeight::where('negara_masters_id', 1)
            ->where('variable_masters_id', 9)
            ->first();

        $array_tahun = $this->get_array_tahun();
        foreach ($mapped as $varKey => $var) {
            if ($varKey == 6) {
                foreach ($var as $tahunKey => $items) {
                    foreach ($items as $key => $item) {
                        $composite = VariableData::where([
                            ['negara_masters_id', '=', 1],
                            ['variable_masters_id', '=', 10],
                            ['tahun', '=', $tahunKey],
                            ['bulan', '=', ($key+1)]
                        ])->first();
                        if ($composite) {
                            $value_gdp = $mapped[$varKey][$tahunKey][$key]->value_index * $weight_gdp->weight;
                            $value_inf = $mapped[$varKey+1][$tahunKey][$key]->value_index * $weight_inf->weight;
                            $value_er = $mapped[$varKey+2][$tahunKey][$key]->value_index * $weight_er->weight;
                            $value_jii = $mapped[$varKey+3][$tahunKey][$key]->value_index * $weight_jii->weight;
                            $composite->value_index = $value_gdp + $value_inf + $value_er + $value_jii;
                            $composite->save();
                        } else {
                            $value_gdp = $mapped[$varKey][$tahunKey][$key]->value_index * $weight_gdp->weight;
                            $value_inf = $mapped[$varKey+1][$tahunKey][$key]->value_index * $weight_inf->weight;
                            $value_er = $mapped[$varKey+2][$tahunKey][$key]->value_index * $weight_er->weight;
                            $value_jii = $mapped[$varKey+3][$tahunKey][$key]->value_index * $weight_jii->weight;
                            $value = $value_gdp + $value_inf + $value_er + $value_jii;
                            $composite = VariableData::create([
                                'negara_masters_id'     => 1,
                                'tahun'                 => $tahunKey,
                                'variable_masters_id'   => 10,
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
        $variable = ['GDP', 'INF', 'ER', 'JII'];
        $arr = [];
        $datas = $this->get_data();
        $mapped = $this->mapping_data_model_index($datas);
        foreach ($mapped as $key => $var) {
            $arr[$variable[$key]] = [];
            foreach ($var as $tahunKey => $value) {
                $arr[$variable[$key]][] = Excel::VARS($value);
            }
        }
        $arr['average_gdp'] = Excel::Average($arr['GDP']);
        $arr['average_inf'] = Excel::Average($arr['INF']);
        $arr['average_er'] = Excel::Average($arr['ER']);
        $arr['average_jii'] = Excel::Average($arr['JII']);
        return $arr;
    }
}
