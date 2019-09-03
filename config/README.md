#about
This a course from Udemy Fullstack web development with laravel and VueJS, creating a Q&A site like stackoverflow,

#installation
At the end of this file ...


#notes:
###################################################################################################################################

----> Because the version of mysql is low, we need to change the "mysql" settings in  /config/database.php to dont get specified key too long error.

'charset' => 'utf8mb4'             .....................> 'charset' => 'utf8'
'collation' => 'utf8mb4_unicode_ci', ...................>'collation' => 'utf8_unicode_ci'


----> for making center align the pagination in /views/questions/index.blade.php , we runned 
$ php artisan vendor:publish --tag=laravel-pagination
it created a vendor/pagination foler in views folder, in bootstrap file added the justify-content-center class to the ul,
and its done.


---->in views/questions/index.blade.php you can see some attributes like user->url, question->url, question->created_date that
doesnt exist, we will add these with setter and getters(accessor and mutator)
 in their related model as helpers.(any other attributes like this will be commented as
 reademe.md, line 20) .


 -->when accessing Elequent Relationship properties, relationship data is lazy loaded.which means the relationship
  data is not actually loaded unill you first access the property,
  To fix this and N+1 query problem we can eager load the relationship at the time we querry the parent model.
  so we can specify which relation should be eager loaded using  "with()" method as seen in QuestionController@index



---->there is at least 2 easy ways to analyze querys, first the way that laravel provides with DB::querylog,
second way to use a package.
we install the package named "barryvdh/laravel-debugbar" using this composer code

    $ composer require barryvdh/laravel-debugbar --dev

now for the first way we can use it like this: 
replace this code instead of the code in QuestionController@index ,then go to browser and refresh '/questions' to see it.

***
/*
*Query Log
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



---->we can make seprate files for complex validations on requests, 

    $ php artisan make:request <Name of request>

    in the created file the rules can be created in 'rules()' method.

    then you can use it as its shown in QuestionController@store(lookat the arguments to store function).import it first :)



---->HTML5 cant understand put,patch,delete methods, so we use the post as form action,
    then define a method_field('') with the actuall method



---->cause we have a destroy mehtod in resource controller , for deleting  we send a delete request to controller
    so we need a a form for it .take notice to csrf filed and method filed
    we can use {{ csrf_field() }} or @csrf 
    also we can user {{ method_field('') }}  or @method('')


---->we want to make urls user freindly, so we will use slug instead of id for QuestionController@show.
    this is a way to make controller use slug instead of id just for one route.
    we exclude it from resource route and define it seperatly.
    then we will implement routeModelBinding:
    go to App/Providers/RouteServiseProvider.php, in 'boot' function bind your custom route parameter.
    the next thing is to change the url in our view ie; change the getter in Question model to send slug instead of id.



---->Because the body of questions are in markdown syntax, we will pass it like below to not be rendered as text.
    then we will add a new accessr to encapsulate body to html .



---->For Authorization on editing and deleting questions there is 2 ways to handle it: 
    1) Gate :
        we can go to AuthServiceProvider, in the 'boot' method define gates for update and delete.
        then from the controller call to these gates like this: 
            \Gate::denies('name', $params)  or \Gate::allows('name', $params) 
        
        lookat /questions/index.blade.php  to see how to show update and delete buttons only for question owner.

        so simply put : define gate in provider, use in controller or view

        Ex:  'update-question', 'delete-question' gate and edit, update,delete method in question controller.

    2) Policy :
        first we need to create a policy class.in terminal use 
            $ php artisan make:policy <NAme>  --model=<NaME of MODEL>
        you will see in created file that there a method for each of the methods in model.
        note: if u dont use a model flag it will generate an empty class .

        so after defining the authorization rule and adding the crated policy to AuthServiceProvider policies array,
        for each of the methods or the methods u want to have authorization impelemnted on them,
        you can go to controller and simply call to authorize method like below and pass the args needed
            // $this->authorize($args);
        
        Ex: update and delete on QuestionController and QuestionPolicy.

        and for showing the buttons in view only for the owner, you call to policy method name instead 
        of the Gate-name in /questions/index.blade.php 
            @can ('update', $question)
            @endcan



---->the cunstructor is a special method that will be excuted first time when a class is instanciated,
    to prevent unlogged on users from accessing the methods, we will check every req with a middlware in construct

###################################################################################################################################

#relations
user() ( 1 - M ) questions() { User ( 1 - M ) Question }