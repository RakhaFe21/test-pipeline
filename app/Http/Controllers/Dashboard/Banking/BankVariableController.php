<?php

namespace App\Http\Controllers\Dashboard\Banking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankVariableController extends Controller
{
    public function index()
    {
        return view('dashboard.bank.variable');
    }

    public function Macroindex()
    {
        return view('dashboard.bank.macro.variable');
    }
}
