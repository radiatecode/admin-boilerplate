<div class="form-group {{ $attributes['form-group-class'] }}">
    @if(! $attributes['no-label'])
        <label for="{{ $attributes['name'] }}">
            <i class="{{ $attributes['label-icon'] ?: 'fas fa-pen-square' }}"></i>
            <span id="{{ $attributes['name'] }}_label">{{ $attributes['label'] ?? str_label($attributes['name']) }}</span>
            {!! $attributes['required'] || $attributes['required-when'] ? '<span class="required">*</span>' : '' !!}
            {!! $attributes['info'] ? '<i class="fa fa-info-circle text-gray" title="'.$attributes['info'].'" style="cursor: pointer"></i>' : '' !!}
        </label>
    @endif
    <input {{ $attributes->merge([
    'id' => $attributes['name'],
    'type' => 'text',
    'name' => $attributes['name'],
    'class'=> 'form-control' . ($errors->has($attributes['name']) ? ' is-invalid' : ''),
    'placeholder' => $attributes['label'] ?? str_label($attributes['name']) . '...',
    'value' => old($attributes['name'], $attributes['default-value'])
    ]) }} {{ $attributes['required-when'] ? 'required' : '' }}/>
    <span class="error invalid-feedback">{{ $errors->first($attributes['name']) }}</span>
</div>
