<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VariableData;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\StandardDeviations;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Averages;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Variances;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\MatrixFunctions;

class SpreadsheetServiceController extends Controller
{
    public static function STDEV(array $array)
    {
        return StandardDeviations::STDEV($array);
    }

    public static function Average(array $array): float
    {
        return Averages::average($array);
    }

    public static function VARS(array $array): float
    {
        return Variances::VAR($array);
    }

    public static function SUM(array $array): float
    {
        return Sum::sumErroringStrings($array);
    }
    
    public static function MINVERSE(array $array): array
    {
        return MatrixFunctions::inverse($array);
    }

    public static function MMULT(array $array, array $array2): array
    {
        return MatrixFunctions::multiply($array, $array2);
    }
}
