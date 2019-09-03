@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center"> 
                        <h2>All Questions</h2>
                        <div class="ml-auto">
                            <a class="btn btn-outline-primary px-3" href="{{ route('questions.create') }} ">Ask Another</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- message partial --}}
                    @include('layouts._message')

                    @foreach ($questions as $question) 
                        <div class="media">
                            {{-- Vote Conter --}}
                            <div class="d-flex flex-column counters" >
                                <div class="vote">
                                    <strong> {{ $question->votes }} </strong> {{ str_plural('vote', $question->votes) }}
                                </div>
                                <div class="status {{ $question->status }}">
                                    <strong> {{ $question->answers }} </strong> {{ str_plural('answer', $question->answers) }}
                                </div>
                                <div class="view">
                                    {{ $question->votes ." ". str_plural('view', $question->views) }}
                                </div>
                            </div>
                            {{-- Question Parts --}}
                            <div class="media-body">
                                {{-- <h3 class="mt-0"> <a href="{{ route('questions.show', $question->id) }}"> {{ $question->title }} ? </a> </h3> --}}
                                {{-- look at: readme.md, line 20 {question->url, question->created_date, question->user->url}--}}
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0"> <a href="{{ $question->url }}"> {{ $question->title }}  </a> </h3>
                                    <div class="ml-auto">
                                        <a class="btn btn-sm btn-outline-info" href=" {{ route('questions.edit', $question->id ) }} "> Edit </a>

                                        {{-- README.md , line: 80 --}}
                                        <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                            @method('DELETE')
                                            {{ csrf_field() }}

                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <p class="lead">
                                    Asked By <a href=" {{ $question->user->url }} "> {{ $question->user->name }} </a>

                                    <small class="text-muted"> {{ $question->created_date }} </small>
                                </p>
                                {{ str_limit($question->body, 250) }}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <div class="">
                        {{ $questions->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
