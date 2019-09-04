<?php

namespace App;

use App\Question;
use App\Answer;

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


    /**polymorphic for user and questions answers vote */
    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
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



    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        if($voteQuestions->where('votable_id', $question->id)->exists())
        {
            $voteQuestions->updateExistingPivot($question, ['vote' => $vote]);
        }else
        {
            $voteQuestions->attach($question, ['vote' => $vote]);
        }


        $question->load('votes');
        $downVotes = (int) $question->votes()->wherePivot('vote', -1)->sum('vote');
        $upVotes = (int) $question->votes()->wherePivot('vote', 1)->sum('vote');
        $question->votes_count = $downVotes + $upVotes;
        $question->save();
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        if($voteAnswers->where('votable_id', $answer->id)->exists())
        {
            $voteAnswers->updateExistingPivot($answer, ['vote' => $vote]);
        }else
        {
            $voteAnswers->attach($answer, ['vote' => $vote]);
        }


        $answer->load('votes');
        $downVotes = (int) $answer->downVotes()->sum('vote');
        $upVotes = (int) $answer->votes()->wherePivot('vote', 1)->sum('vote');
        $answer->votes_count = $downVotes + $upVotes;
        $answer->save();
    }


}//End of Model
