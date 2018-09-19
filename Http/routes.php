<?php

Route::group(['middleware' => ['web', 'lookup:user', 'auth:user'], 'namespace' => 'Modules\Backup\Http\Controllers'], function()
{
    Route::resource('backup', 'BackupController');
    Route::post('backup/bulk', 'BackupController@bulk');
    Route::get('api/backup', 'BackupController@datatable');
});

Route::group(['middleware' => 'api', 'namespace' => 'Modules\Backup\Http\ApiControllers', 'prefix' => 'api/v1'], function()
{
    Route::resource('backup', 'BackupApiController');
});
