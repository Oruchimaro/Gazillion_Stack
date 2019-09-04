@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center"> 
                            <h1> {{ $question->title }} </h1>
                            <div class="ml-auto">
                                <a class="btn btn-outline-primary px-3" href="{{ route('questions.index') }} ">Back To All Questions</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mdeia d-flex ">
                        {{-- Votes Section  --}}
                        <div class="d-flex flex-column vote-controls my-auto">
                            <a title="This question is useful" class="vote-up ">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count  ">45</span>
                            <a title="This question is not useable" class="vote-down off "> 
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a title="Mark as favorite/not favorite" class="favorite {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }} "
                                onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit(); "> 
                                <i class="fas fa-star fa-2x "></i>   
                                <span class="favorites-count" id="am-1" > {{ $question->favorites->count() }} </span>                             
                            </a>
                            <form id="favorite-question-{{ $question->id }}" style="display:none;"
                                action="/questions/{{ $question->id }}/favorites" method="POST">
                                @csrf
                                @if ($question->is_favorited)
                                    @method('DELETE')
                                @endif
                            </form>
                            
                        </div>
                        <div class="media-body">
                            {{-- DOCUMENTATION.md, line: 95 --}}
                            {!! $question->body_html !!}

                            <div class="float-right">
                                <span class="text-muted">
                                    Answered {{ $question->created_date }}
                                </span>
                                <div class="media mt-1">
                                    <a href=" {{ $question->user->url }} " class="pr-2">
                                        <img src="{{ $question->user->avatar }}" alt="" height="32px" width="32px">
                                    </a>
                                    <div class="media-body mt-1">
                                        <a href=" {{ $question->user->url }}"> {{ $question->user->name }} </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- answers section  --}}
     @include('answers._index', [
        'answers' => $question->answers,
        'answersCount' => $question->answers_count,
    ])

    @include('answers._create')
</div>
@endsection
