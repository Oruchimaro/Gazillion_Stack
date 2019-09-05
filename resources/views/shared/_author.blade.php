<span class="text-muted">
    {{ $label }}  {{ $model->created_date }}
</span>
<div class="media mt-1">
    <a href=" {{ $model->user->url }} " class="pr-2">
        <img src="{{ $model->user->avatar }}" alt="" height="32px" width="32px">
    </a>
    <div class="media-body mt-1">
        <a href=" {{ $model->user->url }}"> {{ $model->user->name }} </a>
    </div>
</div>