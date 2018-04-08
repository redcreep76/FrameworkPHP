<?php

Route::get('/', 'HomeController@index');

Route::get('/home/{id:[0-9]+}', 'HomeController@edit');