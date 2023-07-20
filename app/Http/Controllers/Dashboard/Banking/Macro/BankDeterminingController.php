<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\IndexBServiceController;
use App\Models\NegaraMaster;
use Illuminate\Support\Facades\Route;

class BankDeterminingController extends Controller
{
    private $country;
    private $indexService;
    public function __construct() {
        $this->country =  NegaraMaster::where('code', Route::current()->parameter('code'))->first();
        if (!$this->country) {
            return abort(500, 'Something went wrong');
        }
        $this->indexService = new IndexBServiceController($this->country->code);
    }

    public function index()
    {
        $this->indexService->transform_to_index();
        $tahuns = VariableData::select('tahun')
        ->where('negara_masters_id', $this->country->id)
            ->whereNotIn('variable_masters_id', [1,2,3,4,5,10])
            ->groupBy('tahun')
            ->get();
        $data = [];
        $add_on = [];
        if (!$tahuns->isEmpty()) {
            collect($data);
            $vars = $this->indexService->get_vars();
            $i = 0;
            foreach ($tahuns as $tahunKey => $tahun) {
                $data[$tahunKey]['tahun'] = $tahun->tahun;
                $data[$tahunKey]['GDP'] = round($vars['GDP'][$i], 3);
                $data[$tahunKey]['INF'] = round($vars['INF'][$i], 3);
                $data[$tahunKey]['ER'] = round($vars['ER'][$i], 3);
                $data[$tahunKey]['JII'] = round($vars['JII'][$i], 3);
                $i++;
            }

            $add_on['Average']['gdp'] = round($vars['average_gdp'], 3);
            $add_on['Average']['inf'] = round($vars['average_inf'], 3);
            $add_on['Average']['er'] = round($vars['average_er'], 3);
            $add_on['Average']['jii'] = round($vars['average_jii'], 3);
            $add_on['Average']['total'] = array_sum([
                $add_on['Average']['gdp'],
                $add_on['Average']['inf'],
                $add_on['Average']['er'],
                $add_on['Average']['jii']
            ]);

            $add_on['Average']['gdp'] = round($vars['average_gdp'], 3);
            $add_on['Average']['inf'] = round($vars['average_inf'], 3);
            $add_on['Average']['er'] = round($vars['average_er'], 3);
            $add_on['Average']['jii'] = round($vars['average_jii'], 3);
            $add_on['Average']['total'] = array_sum([
                $add_on['Average']['gdp'],
                $add_on['Average']['inf'],
                $add_on['Average']['er'],
                $add_on['Average']['jii']
            ]);

            $add_on['Weight']['gdp'] = round( $add_on['Average']['gdp']/ $add_on['Average']['total'], 3);
            $add_on['Weight']['inf'] = round( $add_on['Average']['inf']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['er'] = round( $add_on['Average']['er']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['jii'] = round( $add_on['Average']['jii']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['total'] = array_sum([
                $add_on['Weight']['gdp'],
                $add_on['Weight']['inf'],
                $add_on['Weight']['er'],
                $add_on['Weight']['jii']
            ]);
        }
        
        // dd($add_on);
        return view('dashboard.bank.macro.determining.index', compact('data', 'add_on'));
    }
}
