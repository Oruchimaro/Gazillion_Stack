<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function __construct ()
    {
         $this->middleware('auth')->except('index');
        //  $this->middleware('auth');
    }

    public function index(Question $question)
    {
        return $question->answers()->with('user')->simplePaginate(3);
    }

    /**
     *  route is 'questions/{question}/answers ' so we need to get a instance of question in the first arg of store()
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $answer = $question->answers()->create(['body' => $request->body, 'user_id' => \Auth::user()->id ]);

        if($request->expectsJson())
        {
            return response()->json([
                'message' => 'This answer is submitted .',
                'answer' => $answer->load('user')  //to eager load user relation with this answer for user-info component
            ]);
        }
        return back()->with('success', "This answer is submitted .");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question,Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact('question', 'answer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);

        $answer->update($request->validate([
            'body' => 'required'
        ]));

        if($request->expectsJson())
        {
            return response()->json([
                'message'=> 'Your answer updated!',
                'body_html' => $answer->body_html
            ]);
        }
        
        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);
        $answer->delete();

        if(request()->expectsJson())
        {
            return response()->json([
                'message'=> 'Your answer has been removed!',
            ]);
        }
        return back()->with('success', "Your answer has been removed");
        //remember to decrement the answer_count in questions table
    }
}
