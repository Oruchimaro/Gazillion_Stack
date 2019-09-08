<?php

namespace App\Http\Controllers;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\AskQuestionRequest;

class QuestionController extends Controller
{
    /**we will define a constructor here to prevent seeing the Ask Question button without loging in,  DOCUMENTATION.md, line:132  */
    public function __construct ()
    {
        //  $this->middleware('auth')->except('index', 'show');
         $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(5); //eager load user relation using "with", see {DOCUMENTATION.md, line:26 }
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
        // dd($question);
        return view('questions.show', compact('question'));
    }


    public function edit(Question $question)
    {
        /**using the policy for authorization */
        // $this->authorize($question);


        /**using the gate for authorization */
        //there is no need for passing current user to gate, cause laravel will handle it 
        if( \Gate::denies('update-question', $question) )
        {
            abort(403, 'Access Denied.');
        }
        return view("questions.edit", compact('question'));
    }


    public function update(AskQuestionRequest $request, Question $question)
    {
        /**using the gate for authorization */
        if( \Gate::denies('update-question', $question) )
        {
            abort(403, 'Access Denied.');
        }


        /**using the policy for authorization */
        // $this->authorize($question);

        $question->update(
            $request->only('title', 'body')
        );


        return redirect('/questions')->with('success', "Updated your question.");
    }

    
    public function destroy(Question $question)
    {
        /**using the policy for authorization */
        // $this->authorize($question);


        /**using the gate for authorization */
        if( \Gate::denies('delete-question', $question) )
        {
            abort(403, 'Access Denied.');
        }

        $question->delete();

        // return redirect()->route('questions.index')
        // ->with('success', "Your question has been Deleted."); 

        return redirect()->back()
        ->with('success', "Your question has been Deleted."); 
    }
}
