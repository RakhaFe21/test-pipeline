<?php

namespace App\Http\Controllers\Landing\Bank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TheoriticalController extends Controller
{
    public function index()
    {
        return view('landing.bank.theoritical');
    }
}
