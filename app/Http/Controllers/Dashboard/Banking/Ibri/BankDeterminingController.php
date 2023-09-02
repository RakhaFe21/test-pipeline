<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Service\IndexServiceController;
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
        $this->indexService = new IndexServiceController($this->country->id);
    }

    public function index()
    {
        $this->indexService->transform_to_index();
        $tahuns = VariableData::select('tahun')
            ->groupBy('tahun')
            ->where('negara_masters_id', $this->country->id)
            ->get();
            $data = [];
            $add_on = [];
        if (!$tahuns->isEmpty()) {
            collect($data);
            $vars = $this->indexService->get_vars();
            $i = 0;
            foreach ($tahuns as $tahunKey => $tahun) {
                $data[$tahunKey]['tahun'] = $tahun->tahun;
                $data[$tahunKey]['NPF'] = number_format($vars['NPF'][$i], 3);
                $data[$tahunKey]['CAR'] = number_format($vars['CAR'][$i], 3);
                $data[$tahunKey]['IPR'] = number_format($vars['IPR'][$i], 3);
                $data[$tahunKey]['FDR'] = number_format($vars['FDR'][$i], 3);
                $i++;
            }
    
            $add_on['Average']['npf'] = number_format($vars['average_npf'], 3);
            $add_on['Average']['car'] = number_format($vars['average_car'], 3);
            $add_on['Average']['ipr'] = number_format($vars['average_ipr'], 3);
            $add_on['Average']['fdr'] = number_format($vars['average_fdr'], 3);
            $add_on['Average']['total'] = array_sum([
                $add_on['Average']['npf'],
                $add_on['Average']['car'],
                $add_on['Average']['ipr'],
                $add_on['Average']['fdr']
            ]);
    
            $add_on['Average']['npf'] = number_format($vars['average_npf'], 3);
            $add_on['Average']['car'] = number_format($vars['average_car'], 3);
            $add_on['Average']['ipr'] = number_format($vars['average_ipr'], 3);
            $add_on['Average']['fdr'] = number_format($vars['average_fdr'], 3);
            $add_on['Average']['total'] = array_sum([
                $add_on['Average']['npf'],
                $add_on['Average']['car'],
                $add_on['Average']['ipr'],
                $add_on['Average']['fdr']
            ]);
    
            $add_on['Weight']['npf'] = number_format( $add_on['Average']['npf']/ $add_on['Average']['total'], 3);
            $add_on['Weight']['car'] = number_format( $add_on['Average']['car']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['ipr'] = number_format( $add_on['Average']['ipr']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['fdr'] = number_format( $add_on['Average']['fdr']/  $add_on['Average']['total'], 3);
            $add_on['Weight']['total'] = array_sum([
                $add_on['Weight']['npf'],
                $add_on['Weight']['car'],
                $add_on['Weight']['ipr'],
                $add_on['Weight']['fdr']
            ]);    
        }
        // dd($add_on);
        return view('dashboard.bank.ibri.determining.index', compact('data', 'add_on'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'npf' => 'required|numeric',
            'car' => 'required|numeric',
            'ipr' => 'required|numeric',
            'fdr' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'message' => 'Invalid Data', 'data' => $validator->errors()], 200);
        }

        $select = VariableWeight::where('negara_masters_id', 1)
            ->whereIn('variable_masters_id', [1, 2, 3, 4])
            ->get();

        if (!$select->count() > 0) {
            return response()->json(['code' => 400, 'message' => 'Variable Weight Data Not Found', 'data' => $validator->errors()], 200);
        }

        $update = DB::transaction(function () use ($request) {
            try {
                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 1)
                    ->update(['weight' => $request->npf]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 2)
                    ->update(['weight' => $request->car]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 3)
                    ->update(['weight' => $request->ipr]);

                VariableWeight::where('negara_masters_id', 1)
                    ->where('variable_masters_id', 4)
                    ->update(['weight' => $request->fdr]);

                return ['code' => 200, 'message' => "Data saved successfully", 'data' => null];
            } catch (Exception $e) {
                return ['code' => 500, 'message' => $e->getMessage(), 'data' => null];
            }
        });

        return response()->json($update, 200);
    }
}
