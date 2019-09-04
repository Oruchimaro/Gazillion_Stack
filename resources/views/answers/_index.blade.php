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

                        {{-- Votes Section  --}}
                        <div class="d-flex flex-column vote-controls my-auto">
                            <a title="This answer is useful" class="vote-up ">
                                <i class="far fa-thumbs-up fa-3x"></i>
                            </a>
                            <span class="votes-count  ">45</span>
                            <a title="This answer is not useable" class="vote-down off "> 
                                <i class="far fa-thumbs-down fa-3x"></i>
                            </a>
                            <a title="Mark as best answer" class=" {{ $answer->status }} "> 
                                <i class="fas fa-check-double fa-2x "></i>                             
                            </a>
                        </div>

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
                                    <span class="text-muted">
                                        Answered {{ $answer->created_date }}
                                    </span>
                                    <div class="media mt-1">
                                        <a href=" {{ $answer->user->url }} " class="pr-2">
                                            <img src="{{ $answer->user->avatar }}" alt="" height="32px" width="32px">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href=" {{ $answer->user->url }}"> {{ $answer->user->name }} </a>
                                        </div>
                                    </div>
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