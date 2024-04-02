@props(['type', 'labelName', 'wrapStyle', 'labelStyle', 'inputStyle'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName }}</label>
    <div class="{{ $inputStyle ?? "" }}">
        <input type="{{ $type }}" {{ $attributes }}/>
    </div>
</div>