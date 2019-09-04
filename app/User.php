<?php

namespace App;

use App\Question;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /***************************************Relations **************************************/
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function favorites()
    {
        /*Many to Many Relations
        * In  relations the arguments are modelName, tableName, foreignKeyOfModel, foreignLeyOfMdelThatISGEttingJoined
        *  $this->belongsToMany(Question::class, 'favorites', 'user_id', 'question_id') 
        *its usefull when the name of table and foreign keys are not defined as laravel convention
        */
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); 
    }


    /***************************************Helpers **************************************/
    /**these accessors help format Elquent attribytes when we retrive them from model instances*/
    public function getUrlAttribute()
    {
        return route('questions.show', $this->id);
    }



    public function getAvatarAttribute()
    { /**https://en.gravatar.com/site/implement/images/php/ */
        $email = $this->email;
        $size = 32;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) ."&s=" . $size;
    }





}//End of Model
