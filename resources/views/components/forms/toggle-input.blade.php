@props([
'value' => '',
'label' => '',
'name' => '',
'is_checked' => false,
'is_disabled' => false
])

<div class="field has-toggle">
	@if ($label !== '')
		<div class="label">{{ $label }}</div>
	@endif
    <label for="form-{{ $name }}">
		<div class="toggle{{ ($is_disabled ? ' is-disabled' : '') }}">
			<input id="form-{{ $name }}" name="{{ $name }}" value="true" type="checkbox" class="checkbox" {{ ($is_checked ? 'checked' : '') }} {{ ($is_disabled ? 'disabled' : '') }} />
			<span class="toggle-slider"></span>
		</div>
	</label>
</div>
