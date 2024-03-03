<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    echo '<pre>';
   print_r(\Ip2location\IP2LocationLaravel\Facade\IP2LocationLaravel::get('1.55.227.146'));
});
