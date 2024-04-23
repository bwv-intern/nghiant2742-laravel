@props(['type', 'labelName', 'wrapStyle', 'labelStyle', 'inputStyle'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName ?? "" }} <span class="required">{{ $attributes['require']==true?" *":""}}</span></label>
    <div class="{{ $inputStyle ?? "" }}">
        <input type="{{ $type }}" {{ $attributes }}/>
    </div>
</div>