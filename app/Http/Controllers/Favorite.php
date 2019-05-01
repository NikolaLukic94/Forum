<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Favorite extends Controller
{
	use RecordsActivity;

    protected $guarded = [];

    public function favorited() {

    	return $this->morphTo();
    }
}
