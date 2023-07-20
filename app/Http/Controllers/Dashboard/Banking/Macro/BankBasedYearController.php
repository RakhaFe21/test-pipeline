<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use App\Models\NegaraMaster;
use App\Models\VariableData;
use App\Models\VariableWeight;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class BankBasedYearController extends Controller
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

        $weight = VariableWeight::where('negara_masters_id', $this->country->id)->whereNotIn('variable_masters_id', [1,2,3,4])->get();

        return view('dashboard.bank.macro.basedyear.index', compact( 'weight'));
    }
}
