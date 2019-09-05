@can('accept', $model)
    <a title="Mark as best answer" class=" {{ $model->status }} " 
        onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit(); "> 
        <i class="fas fa-check-double fa-2x "></i>                             
    </a>

    <form id="accept-answer-{{ $model->id }}" style="display:none;"
        action="{{ route('answers.accept', $model->id) }}" method="POST">
        @csrf
    </form>
@else
    @if ($model->is_best)
    <a title="The owner accepted this answer as best" class=" {{ $model->status }} " > 
        <i class="fas fa-check-double fa-2x "></i>                             
    </a>
    @endif
@endcan