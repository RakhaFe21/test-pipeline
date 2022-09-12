<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableData extends Model
{
    use HasFactory;

    public function negaraMaster()
    {
        return $this->hasMany(NegaraMaster::class);
    }

    public function variableMaster()
    {
        return $this->hasMany(variableMaster::class);
    }
}
