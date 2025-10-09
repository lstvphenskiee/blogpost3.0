@props(['method' => 'POST', 'action' => '#'])

@php
    $httpMethod = strtoupper($method);
@endphp

<form 
    method="{{ $httpMethod === 'GET' ? 'GET' : 'POST' }}" 
    action="{{ $action }}" 
    {{ $attributes->merge(['class' => 'form mb-3']) }}
>
    @csrf

    {{-- Spoof method for PUT, PATCH, DELETE --}}
    @if (in_array($httpMethod, ['PUT', 'PATCH', 'DELETE']))
        @method($httpMethod)
    @endif

    {{ $slot }}
</form>
