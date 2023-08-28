<?php

namespace App\Http\Controllers\Landing\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

class TheoriticalMacroController extends Controller
{
    public function __construct() {
        App::setLocale(Route::current()->parameter('locale') ?? 'id');
    }
    
    public function index()
    {
        return view('landing.macro.theoritical');
    }
}
