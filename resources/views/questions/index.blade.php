@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><strong>All Questions</strong></div>

                <div class="card-body">
                    @foreach ($questions as $question) 
                        <div class="media">
                            <div class="media-body">
                                {{-- <h3 class="mt-0"> <a href="{{ route('questions.show', $question->id) }}"> {{ $question->title }} ? </a> </h3> --}}
                                {{-- look at: readme.md, line 20 {question->url, question->created_date, question->user->url}--}}
                                <h3 class="mt-0"> <a href="{{ $question->url }}"> {{ $question->title }} ? </a> </h3>
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
