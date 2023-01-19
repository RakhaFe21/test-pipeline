<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class NullHypothesisData extends Model
{
    use HasFactory;

    protected $table = 'null_hypothesis_data';

    public $fillable = [
        'null_hypothesis',
        'obs',
        'fStatic',
        'prob',
        'jenis',
        'id_negara'
    ];
}
