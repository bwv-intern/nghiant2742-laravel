@props(['labelName', 'wrapStyle', 'labelStyle', 'inputStyle', 'rows'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName }}</label>
    <div class="{{ $inputStyle ?? "" }}">
        <textarea name="{{ $attributes['name'] }}" rows="{{ $rows }}" id="{{ $attributes['id'] }}">{{ $attributes['value'] }}</textarea>
    </div>
</div>