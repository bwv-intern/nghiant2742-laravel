@props(['type', 'labelName', 'wrapStyle', 'labelStyle', 'inputStyle'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="datepicker" class="{{ $labelStyle ?? "" }}">{{ $labelName }} <span class="required">{{ $attributes['require']==true?" *":""}}</span></label>
    <div class="{{ $inputStyle ?? "" }}">
        <input type="text" {{ $attributes }}>
    </div>

</div>