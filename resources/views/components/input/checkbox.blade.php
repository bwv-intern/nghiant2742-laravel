@props(['type', 'labelName', 'wrapStyle', 'labelStyle', 'inputStyle', 'name', 'options'])

<div class="{{ $wrapStyle ?? "" }}">
    <label for="{{ $attributes['id'] }}" class="{{ $labelStyle ?? "" }}">{{ $labelName }}</label>
    <div class="{{ $inputStyle ?? "" }}">
        @foreach($options as $option)
            <input type="checkbox" id="{{ $option['id'] }}" name="{{ $name }}[]" value="{{ $option['value'] }}" {{ $option['checked'] ? 'checked' : '' }}/>
            <label for="{{ $option['id'] }}">{{ $option['label'] }}</label>
        @endforeach
    </div>
</div>