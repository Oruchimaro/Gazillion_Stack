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
        ->with('success', "Submitted your question."); //we will show the flash message in layout folder
    }


    public function show(Question $question)
    {
        // $question->views = $question->views +1 ;
        // $question->save();

        $question->increment('views'); //this is the same as the above code, its cleaner
        return view('questions.show', compact('question'));
    }


    public function edit(Question $question)
    {
        return view("questions.edit", compact('question'));
    }


    public function update(AskQuestionRequest $request, Question $question)
    {
        $question->update(
            $request->only('title', 'body')
        );

        return redirect('/questions')->with('success', "Updated your question.");
    }

    
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('questions.index')
        ->with('success', "Your question has been Deleted."); 
    }
}
