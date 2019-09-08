@if ($model instanceof App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp

@elseif ($model instanceof App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif

<div class="d-flex flex-column vote-controls my-auto">
    <a title="This {{ $name }} is useful" class="vote-up {{ Auth::guest() ? 'off' : '' }}"
        onclick="event.preventDefault(); document.getElementById('up-vote-{{ $name }}-{{ $model->id }}').submit(); ">
        <i class="fas fa-caret-up fa-3x"></i>
        
    </a>
    <form id="up-vote-{{ $name }}-{{ $model->id }}" style="display:none;"
        action="/{{ $firstURISegment }}/{{ $model->id }}/vote" method="POST">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    

    <span class="votes-count  "> {{ $model->votes_count }} </span>

    <a title="This {{ $name }} is not useable" class="vote-down {{ Auth::guest() ? 'off' : '' }} "
    onclick="event.preventDefault(); document.getElementById('down-vote-{{ $name }}-{{ $model->id }}').submit(); "> 
        <i class="fas fa-caret-down fa-3x"></i>
        
    </a>
    <form id="down-vote-{{ $name }}-{{ $model->id }}" style="display:none;"
        action="/{{ $firstURISegment }}/{{ $model->id }}/vote" method="POST">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    

    <!-- Favorites controll -->
    @if ($model instanceof App\Question)
        <favorite :question="{{ $model }}"></favorite>
    @elseif ($model instanceof App\Answer)
        @include('shared._accept', [
            'model' => $model
        ])
    @endif
    
</div>