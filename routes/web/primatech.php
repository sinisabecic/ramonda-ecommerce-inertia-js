<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['admin', 'auth'],
], function () {
    
//? Primatech API
    Route::get('/admin/api/primatech/clients', 'EFiscalApiController@index')
        ->name('primatech.clients');

    Route::get('/admin/api/primatech/clients/{vat}', 'EFiscalApiController@show')
        ->name('primatech.clients.companyByVAT');

});