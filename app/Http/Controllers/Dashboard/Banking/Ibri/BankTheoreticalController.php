<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BankTheoreticalController extends Controller
{
    private string $code;

    public function __construct()
    {
        $this->code = Route::current()->parameter('code');
    }
    
    public function index()
    {
        return view('dashboard.bank.ibri.theoretical.index');
    }
}
