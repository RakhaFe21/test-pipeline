<?php

namespace App\Http\Controllers\Dashboard\Banking\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankTheoriticalController extends Controller
{
    public function index()
    {
        return view('dashboard.bank.macro.theoretical.index');
    }
}
