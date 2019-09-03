<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5); //eager load user relation using "with", see {readme.md, line:26 }
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
    
    }

    public function show(Question $question)
    {

    }

    public function edit(Question $question)
    {
        //
    }

    public function update(Request $request, Question $question)
    {
        //
    }

    public function destroy(Question $question)
    {
        //
    }
}
