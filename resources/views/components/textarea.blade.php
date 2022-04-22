<div class="form-group">
    @if(!$attributes['no-label'])
        <label for="{{ $attributes['name'] }}">
            {{ $attributes['label'] ?? str_label($attributes['name']) }} {!! $attributes['required'] ? '<span class="required">*</span>' : '' !!}
        </label>
    @endif
    <textarea {{ $attributes->merge([
    'id' => $attributes['name'],
    'name' => $attributes['name'],
    'class'=> 'form-control' . ($errors->has($attributes['name']) ? ' is-invalid' : ''),
    'placeholder' => $attributes['label'] ?? str_label($attributes['name']) . '...'
    ]) }}
    >{{ old($attributes['name'],$attributes['default-value']) }}</textarea>
    <span class="error invalid-feedback">{{ $errors->first($attributes['name']) }}</span>
</div>
