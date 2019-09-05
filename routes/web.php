<?php


Route::get('/', 'QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('questions', 'QuestionController')->except(['show']);  //README.md, line:85
Route::get('/questions/{slug}', 'QuestionController@show')->name('questions.show');
Route::resource('questions.answers', 'AnswerController')->except(['index', 'create', 'show']);
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept'); //single action controller
Route::post('questions/{question}/favorites', 'FavoritesController@store')->name('questions.favorite');
Route::delete('questions/{question}/favorites', 'FavoritesController@destroy')->name('questions.unfavorite');
Route::post('/questions/{question}/vote', 'VoteQuestionController')->name('questions.vote');
Route::post('/answers/{answer}/vote', 'VoteAnswerController')->name('answers.vote');





