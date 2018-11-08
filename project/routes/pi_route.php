<?php

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'routeAccess'], function () {
    Route::post('pi/generate/report',
        [
            'as'=>'pi_generate_action',
            'uses'=>'taskController\pi\PiController@piGenerate'
        ]);

    Route::get('pi/list/views',
        [
            'as'=>'pi_list_view',
            'uses'=>'taskController\pi\PiListController@getPiList'
        ]);
    Route::get('pi/list/report',
        [
            'as'=>'pi_list_report_view',
            'uses'=>'taskController\pi\PiListController@getPiReport'
        ]);
    Route::get('pi/cancel/{p_id}','taskController\pi\PiController@piEdit')->name('pi_edit_action');
    });
});