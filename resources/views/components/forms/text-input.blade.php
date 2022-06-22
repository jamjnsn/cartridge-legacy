@props([
'type' => 'text',
'value' => '',
'placeholder' => '',
'label' => '',
'name' => ''
])

<div class="field">
    @if ($label !== '')
    <label for="form-{{ $name }}" class="label">{{ $label }}</label>
    @endif

    <input id="form-{{ $name }}" name="{{ $name }}" value="{{ $value }}" type="{{ $type }}" class="input" />
</div>
