<?php

namespace App\Http\Controllers\Landing\Macro;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TheheatmapMacroController extends Controller
{
    public function index()
    {
        return view('landing.macro.theheatmap');
    }
}
