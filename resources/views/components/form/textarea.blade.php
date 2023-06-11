<div class="form-group {{ $attributes['form-group-class'] }}">
    @if(!$attributes['no-label'])
        <label id="{{ $attributes['name'] }}_label" for="{{ $attributes['name'] }}">
            <i class="{{ $attributes['label-icon'] ?: 'fas fa-pen-square' }}"></i>
            {{ $attributes['label'] ?? str_label($attributes['name']) }}
            {!! $attributes['required'] ? '<span class="required">*</span>' : '' !!}
            {!! $attributes['info'] ? '<i class="fa fa-info-circle text-gray" title="'.$attributes['info'].'" style="cursor: pointer"></i>' : '' !!}
        </label>
    @endif
    <textarea {{ $attributes->merge([
    'id' => $attributes['name'],
    'name' => $attributes['name'],
    'class'=> 'form-control' . ($errors->has($attributes['name']) ? ' is-invalid' : ''),
    'placeholder' => $attributes['label'] ?? str_label($attributes['name']) . '...'
    ]) }}>{{ old($attributes['name'],$attributes['value']) }}</textarea>
    <span class="error invalid-feedback">{{ $errors->first($attributes['name']) }}</span>
</div>
