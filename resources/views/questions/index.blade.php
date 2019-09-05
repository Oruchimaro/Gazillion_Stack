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
                            <a class="btn btn-outline-success px-3" href="{{ route('questions.create') }} ">Ask Another</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Message partial -->
                        @include('layouts._message')
                    <!--End Mesage Partials -->

                    <!--Questions Section -->
                        @forelse ($questions as $question) 
                            @include('questions._excerpt')
                        @empty
                            <div class="alert alert-warning">
                                <strong>Sorry!!!</strong> <p>There IS No Questions Available.</p>
                            </div>
                        @endforelse
                    <!--End Questions Section -->

                    <!--Pagination --> 
                        {{ $questions->links() }}
                    <!--End Pagination -->                     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
