<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth');
    }


    public function store(Question $question)
    {
        $question->favorites()->attach(auth()->id());

        if(request()->expectsJson())
        {
            return response()->json(null, 204); //204 action completed successfully but nothing to return
        }
    }


    
    public function destroy(Question $question)
    {
        $question->favorites()->detach(auth()->id());

        if(request()->expectsJson())
        {
            return response()->json(null, 204); 
        }
    }
}
