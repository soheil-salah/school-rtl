<div class="form-group {{ isset($formGroupClass) ? $formGroupClass : null }}">
    <label for="{{ $label }}">{{ $title }}</label>
    <select {{ $attributes->merge(['class' => 'form-control']) }}>
        {{ $slot }}
    </select>
</div>