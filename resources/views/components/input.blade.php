@props(['name', 'type' => 'text', 'label' => null, 'placeholder' => ''])
<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ ucfirst($label ?? $name) }}</label>
    <input 
        type="{{ $type ?? 'text' }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ old($name) }}" 
        class="form-control"
        placeholder="{{ $placeholder ?? '' }}"
    >
    @error($name)
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
