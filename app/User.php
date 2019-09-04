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
