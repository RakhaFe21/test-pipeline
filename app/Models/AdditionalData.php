<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalData extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function negaraMaster()
    {
        return $this->hasMany(NegaraMaster::class);
    }
}
