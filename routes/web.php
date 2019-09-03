<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController')->except('show');  //README.md, line:85
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');

