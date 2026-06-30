@props(['field'])

@error($field)
    <p {{ $attributes->merge(['class' => 'auth-field__error', 'role' => 'alert']) }}>{{ $message }}</p>
@enderror
