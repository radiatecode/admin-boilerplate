@props(['message','type'])

<div class="alert {{ $type }} alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h5><i class="icon fas {{ $attributes['title-icon'] ?: 'fa-check' }}"></i> {{ $attributes['title'] ?: 'Alert!' }}</h5>
    {{ $message }}
</div>
