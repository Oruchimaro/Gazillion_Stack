<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');
Route::resource('questions', 'QuestionController')->except('questions');  //README.md, line:85
Route::resource('questions.answers', 'AnswerController')->except(['index', 'create', 'show']);


// Route::post('/questions/{question}/answers', 'AnswerController@store')->name('answers.store');






