@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center"> 
                        <h1> {{ $question->title }} </h1>
                        <div class="ml-auto">
                            <a class="btn btn-outline-primary px-3" href="{{ route('questions.index') }} ">Back To All Questions</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- DOCUMENTATION.md, line: 95 --}}
                    {!! $question->body_html !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
