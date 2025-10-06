@props(['method' => 'POST', 'action'])

<form method="{{ $method }}" action="{{ $action }}" {{ $attributes->merge(['class' => 'form-floating mb-3']) }}>
    @csrf
    {{ $slot }}
</form>
