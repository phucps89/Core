<?php

use \Illuminate\Support\Facades\Route;
use Sel2b\Core\Libraries\Constant;

Route::get('/', function(){
    return view(Constant::NAMESPACE . '::home');
});