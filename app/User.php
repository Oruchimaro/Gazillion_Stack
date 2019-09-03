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
    /***************************************Helpers **************************************/
    /**these accessors help format Elquent attribytes when we retrive them from model instances*/
    public function getUrlAttribute()
    {
        return route('questions.show', $this->id);
        return '#';
    }
}//End of Model
