<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2> {{ $answersCount . " " . str_plural('Answer', $answersCount) }} </h2>
                </div>
                <hr>
                @include('layouts._message')
                @foreach ($answers as $answer)
                    <div class="media">

                        <!-- Vote Controls section -->
                        @include('shared._vote', [
                            'model' => $answer
                        ])
                        <!-- End Vote Controls section -->

                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row" >
                                <div class="col-4" >
                                    @guest
                                        
                                    @else
                                        @can('update', $answer) 
                                            <a class="btn btn-sm btn-outline-info" href=" {{ route('questions.answers.edit', [$question->id, $answer->id]  ) }} "> Edit </a>
                                        @endcan

                                        @can('delete', $answer) 

                                            {{-- DOCUMENTATION.md , line: 80 --}}
                                            <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST">
                                                @method('DELETE')
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        @endcan
                                    @endguest
                                </div>
                                 
                                <div class="col-4"></div>

                                <div class="col-4">
                                    @include('shared._author', [
                                        'model' => $answer,
                                        'label' => 'answered'
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>      
                    <hr>                  
                @endforeach
            </div>
        </div>
    </div>
</div>