<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableWeight extends Model
{
    use HasFactory;

    public function negaraMaster()
    {
        return $this->hasMany(NegaraMaster::class);
    }

    public function variableMaster()
    {
        return $this->belongsTo(variableMaster::class, 'variable_masters_id', 'id');
    }
}
