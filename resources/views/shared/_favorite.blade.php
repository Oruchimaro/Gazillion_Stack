<a title="Mark as favorite/not favorite" class="favorite {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }} "
    onclick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit(); "> 
    <i class="fas fa-star fa-2x "></i>   
    <span class="favorites-count" id="am-1" > {{ $model->favorites->count() }} </span>                             
</a>
<form id="favorite-question-{{ $model->id }}" style="display:none;"
    action="/questions/{{ $model->id }}/favorites" method="POST">
    @csrf
    @if ($model->is_favorited)
        @method('DELETE')
    @endif
</form>