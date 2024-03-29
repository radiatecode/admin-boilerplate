@props([
    'id' => str_replace('[]', '', $attributes['name']),
])
<div class="form-group {{ $attributes['form-group-class'] }}">
    @if (!$attributes['no-label'])
        <label id="{{ $id }}_label" for="{{ $id }}">
            <i class="{{ $attributes['label-icon'] ?: 'fas fa-check-square' }}"></i>
            {{ $attributes['label'] ?? str_label($id) }}
            {!! $attributes['required'] ? '<span class="required">*</span>' : '' !!}
        </label>
    @endif
    @if ($attributes['data-create-new'])
        <a href="{{ $attributes['data-create-new'] }}" target="_blank" class="float-right">Add New +</a>
    @endif
    <select
        {{ $attributes->merge([
            'id' => $id,
            'class' => 'form-control' . ($errors->has($id) ? ' is-invalid' : ''),
        ]) }}>
        @if (old('_' . $id . '_text'))
            <option value="{{ old($id) }}" selected>{{ old('_' . $id . '_text') }}</option>
        @else
            {{ $slot }}
        @endif
    </select>
    <input type="hidden" id="_{{ $id }}_text" name="_{{ $id }}_text"
        value="{{ old('_' . $id . '_text') }}">
    <span class="error invalid-feedback">{{ $errors->first($id) }}</span>
</div>
@prepend('js')
    <script type="text/javascript">
        let ${{ $id }} = $('#{{ $id }}').select2({
            placeholder: 'Select {{ $attributes['label'] ?? str_label($id) }}...',
            width: '100%',
            allowClear: '{{ (bool) $attributes['allowclear'] }}',
            ajax: {
                url: function() {
                    if ('{{ $attributes['depends-on'] }}') {
                        return '{{ $attributes['data-url'] }}'.replace(':id', $('#{{ $attributes['depends-on'] }}').val())
                    }

                    return '{{ $attributes['data-url'] }}'
                },
                data: function(params) {
                    let data = {
                        search: params.term,
                        page: params.page || 1
                    };

                    if ('{{ $attributes['params'] }}') {
                        let extraParams = '{{ $attributes['params'] }}'.split(':');

                        for (let item in extraParams) {
                            let paramElm = extraParams[item];

                            data[paramElm] = $('#' + paramElm).val()
                        }
                    }

                    return data;
                }
            }
        }).on('select2:select', function(event) {
            let selectedData = event.params.data;

            $('#_{{ $id }}_text').val(selectedData.text);
            // console.log(selectedData);
        });
    </script>
@endprepend
