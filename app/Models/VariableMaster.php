<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableMaster extends Model
{
    use HasFactory;

    public function variableData()
    {
        return $this->hasMany(VariableData::class, 'variable_masters_id', 'id');
    }

    public function variableWeight()
    {
        return $this->belongsTo(VariableWeight::class);
    }
}
