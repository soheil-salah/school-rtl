<div class="form-group {{ isset($formGroupClass) ? $formGroupClass : null }}">
    <label for="{{ $label }}">{{ $title }}</label>
    {{ $slot }}
    <input {{ $attributes->merge(['type' => 'text', 'class' => 'form-control']) }}>
</div>