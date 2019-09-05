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

                    <!--Questions Section -->
                    @forelse ($questions as $question) 
                        <div class="media">
                            {{-- Vote Conter --}}
                            <div class="d-flex flex-column counters" >
                                <div class="vote">
                                    <strong> {{ $question->votes_count }} </strong> {{ str_plural('vote', $question->votes_count) }}
                                </div>
                                <div class="status {{ $question->status }}">
                                    <strong> {{ $question->answers_count }} </strong> {{ str_plural('answer', $question->answers_count) }}
                                </div>
                                <div class="view">
                                    {{ $question->views ." ". str_plural('view', $question->views) }}
                                </div>
                            </div>
                            {{-- Question Parts --}}
                            <div class="media-body">
                                {{-- <h3 class="mt-0"> <a href="{{ route('questions.show', $question->id) }}"> {{ $question->title }} ? </a> </h3> --}}
                                {{-- look at: DOCUMENTATION.md, line 20 {question->url, question->created_date, question->user->url}--}}
                                <div class="d-flex align-items-center">
                                    <h3 class="mt-0"> <a href="{{ $question->url }}"> {{ $question->title }}  </a> </h3>
                                    <div class="ml-auto">

                                        {{-- Edit and delete  --}}
                                        @guest
                                            
                                        @else
                                            @if( Auth::user()->can('update-question', $question) )
                                                <a class="btn btn-sm btn-outline-info" href=" {{ route('questions.edit', $question->id ) }} "> Edit </a>
                                            @endif

                                            @if( Auth::user()->can('delete-question', $question) )

                                                {{-- DOCUMENTATION.md , line: 80 --}}
                                                <form class="form-delete" action="{{ route('questions.destroy', $question->id) }}" method="POST">
                                                    @method('DELETE')
                                                    {{ csrf_field() }}

                                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            @endif
                                        @endguest

                                    </div>
                                </div>
                                
                                <p class="lead">
                                    Asked By <a href=" {{ $question->user->url }} "> {{ $question->user->name }} </a>

                                    <small class="text-muted"> {{ $question->created_date }} </small>
                                </p>
                                <!-- -->
                                <div class="excerpt" >{{ $question->excerpt(350) }}</div>
                            </div>
                        </div><hr>
                    @empty
                        <div class="alert alert-warning">
                            <strong>Sorry!!!</strong> <p>There IS No Questions Available.</p>
                        </div>
                    @endforelse
                    <!--End Questions Section -->

                    <div class="">
                        {{ $questions->links() }}
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
