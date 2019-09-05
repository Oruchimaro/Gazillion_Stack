<div class="media post">
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


    <!-- Question Section -->
    <div class="media-body">
        {{-- look at: DOCUMENTATION.md, line 20 {question->url, question->created_date, question->user->url}--}}
        <div class="d-flex align-items-center">
            <h3 class="mt-0"> <a href="{{ $question->url }}"> {{ $question->title }}  </a> </h3>
            <div class="ml-auto">

                <!--Edit and delete  -->
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
                <!--End Edit and Delete -->
            </div>
        </div>
        
        <p class="lead"> Asked By <a href=" {{ $question->user->url }} "> {{ $question->user->name }} </a> <small class="text-muted"> {{ $question->created_date }} </small></p>

        <div class="excerpt" >{{ $question->excerpt(350) }}</div>
    </div>
    <!-- End Question Section -->
</div>