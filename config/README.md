#about


#installation


#notes:
###################################################################################################################################
--> Because the version of mysql is low, we need to change the "mysql" settings in  /config/database.php to dont get specified key too long error.

'charset' => 'utf8mb4'             .....................> 'charset' => 'utf8'
'collation' => 'utf8mb4_unicode_ci', ...................>'collation' => 'utf8_unicode_ci'


--> for making center align the pagination in /views/questions/index.blade.php , we runned 
$ php artisan vendor:publish --tag=laravel-pagination
it created a vendor/pagination foler in views folder, in bootstrap file added the justify-content-center class to the ul,
and its done.

-->in views/questions/index.blade.php you can see some attributes like user->url, question->url, question->created_date that
doesnt exist, we will add these with setter and getters(accessor and mutator)
 in their related model as helpers.(any other attributes like this will be commented as
 reademe.md, line 20) .


 -->when accessing Elequent Relationship properties, relationship data is lazy loaded.which means the relationship
  data is not actually loaded unill you first access the property,
  To fix this and N+1 query problem we can eager load the relationship at the time we querry the parent model.
  so we can specify which relation should be eager loaded using  "with()" method as seen in QuestionController@index

-->there is at least 2 easy ways to analyze querys, first the way that laravel provides with DB::querylog,
second way to use a package.
we install the package named "barryvdh/laravel-debugbar" using this composer code

    $ composer require barryvdh/laravel-debugbar --dev

now for the first way we can use it like this: 
replace this code instead of the code in QuestionController@index ,then go to browser and refresh '/questions' to see it.

***
/**Query Log
* Start:
*    \DB::enableQueryLog();
*    // $questions = Question::latest()->paginate(5);
*    // $questions = Question::latest()->paginate(8);
*    $questions = Question::with('user')->latest()->paginate(5); //eager load user relation 
*    view('questions.index', compact('questions'))->render();
*    dd(\DB::getQueryLog());
*End
*/
***

for the second way use the previous code and go to '/questions',
you can see a tiny icon on left bottom of screen, if u click it the bar will open,
its easy from there.
###################################################################################################################################

#relations
user() ( 1 - M ) questions() { User ( 1 - M ) Question }