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

                        <!-- Vote Controls section -->
                        <vote :model="{{ $question }}" name="question"></vote>
                        <!-- End Vote Controls section -->
                        
                        <div class="media-body">
                            {{-- DOCUMENTATION.md, line: 95 --}}
                            {!! $question->body_html !!}

                            <div class="row">
                                <div class="col-4"></div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info v-bind:model="{{ $question }}" label="Asked" ></user-info>
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
