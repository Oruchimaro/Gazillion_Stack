@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center"> 
                        <h2>Edit This </h2>
                        <div class="ml-auto">
                            <a class="btn btn-outline-primary px-3" href="{{ route('questions.index') }} ">Back To All Questions</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <form action="{{ route('questions.update', $question->id) }}" method="post">
                        {{-- DOCUMENTATION.md, line 75 --}}
                        {{ @method_field('PUT') }}
                        @include('questions._form', ['buttonText' => "Update Question"])
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
