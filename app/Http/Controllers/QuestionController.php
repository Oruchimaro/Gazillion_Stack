<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5); //eager load user relation using "with", see {readme.md, line:26 }
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        $question = new Question();
        return view('questions.create', compact('question'));
    }

    public function store(AskQuestionRequest $request)
    {
        /**this will add user_id value to question model, we need it for questions */
        $request->user()->questions()->create(
            $request->only('title', 'body')
        ); 

        return redirect()->route('questions.index')
        ->with('success', "Submitted ypur question."); //we will show the flash message in layout folder
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
