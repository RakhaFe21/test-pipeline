<?php

use App\Models\NegaraMaster;

if (!function_exists('list_country')) {
    function list_country() {
        return NegaraMaster::get();
    }
}