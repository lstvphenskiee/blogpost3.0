<button 
    type="{{ $type ?? 'button' }}" 
    {{ $attributes->merge(['class' => ' btn btn-'.($variant ?? 'primary')]) }}
>
    {{ $slot }}
</button>