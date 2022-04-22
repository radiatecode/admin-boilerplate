<div class="form-group">
    @if(! $attributes['no-label'])
        <label for="{{ $attributes['name'] }}">
            {{ $attributes['label'] ?? str_label($attributes['name']) }}
            {!! $attributes['required'] ? '<span class="required">*</span>' : '' !!}
            {!! $attributes['info'] ? '<i class="fa fa-info-circle text-gray" title="'.$attributes['info'].'" style="cursor: pointer"></i>' : '' !!}
        </label>
    @endif
    @if($attributes['data-create-new'])
        <a href="{{ $attributes['data-create-new'] }}" target="_blank" class="float-right">Add New +</a>
    @endif
    <input {{ $attributes->merge([
    'id' => $attributes['name'],
    'type' => 'text',
    'name' => $attributes['name'],
    'class'=> 'form-control' . ($errors->has($attributes['name']) ? ' is-invalid' : ''),
    'placeholder' => $attributes['label'] ?? str_label($attributes['name']) . '...',
    'value' => old($attributes['name'], $attributes['default-value'])
    ]) }} />
    <span class="error invalid-feedback">{{ $errors->first($attributes['name']) }}</span>
</div>
