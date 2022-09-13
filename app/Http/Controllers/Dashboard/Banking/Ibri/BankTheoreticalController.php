<?php

namespace App\Http\Controllers\Dashboard\Banking\Ibri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankTheoreticalController extends Controller
{
    public function index()
    {
        return view('dashboard.bank.ibri.theoretical-framework.index');
    }
}
