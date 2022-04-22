<div class="form-group">
    <div class="custom-control custom-checkbox">
        <input class="custom-control-input" type="checkbox" {{ $attributes->merge([
            'id' => $attributes['name'],
            'name' => $attributes['name']
        ]) }} {{ $attributes['checked-when'] ? 'checked' : '' }}>
        <label for="{{ $attributes['name'] }}" class="custom-control-label">{{ $attributes['label'] }}</label>
    </div>
</div>
