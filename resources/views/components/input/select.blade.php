@props(['labelName', 'wrapStyle', 'labelStyle', 'inputStyle', 'options', 'defaultValue'])
<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName }}<span class="required">{{ $attributes['require']==true?" *":""}}</label>
    <div class="{{ $inputStyle ?? "" }}">
        <select name="{{ $attributes['name'] }}" class="shortenedSelect">
            @foreach ($options as $key => $value)
                <option type="option" value="{{ $key }}" {{ $defaultValue == $key ? "selected" : "" }}>{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>