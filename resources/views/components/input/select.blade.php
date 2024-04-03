@props(['labelName', 'wrapStyle', 'labelStyle', 'inputStyle', 'options', 'defaultValue'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName }}</label>
    <div class="{{ $inputStyle ?? "" }}">
        <select name="{{ $attributes['name'] }}">
            @foreach ($options as $key => $value)
                <option type="option" value="{{ $key }}" {{ $defaultValue == $key ? "selected" : "" }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>