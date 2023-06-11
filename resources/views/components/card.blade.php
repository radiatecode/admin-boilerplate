
@props([
    'card_class' => $attributes['class'] ?: 'border-top-green-light card-outline',
])

<div class="card {{ $card_class }}">
    <div class="card-header">
        <h3 class="card-title">
            {{ $attributes['title'] }}
        </h3>
        {{ $header ?? '' }}
    </div>
    <div class="card-body">
        {{ $body }}
    </div>
    <div class="card-footer">
        {{ $footer ?? '' }}
    </div>
</div>