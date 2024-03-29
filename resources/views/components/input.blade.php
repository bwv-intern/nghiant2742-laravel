@props(['type', 'labelName'])
<div>
    <label for="email">{{ $labelName }}</label>
    <div class="group-input">
        <input type="{{ $type }}" {{ $attributes }}/>
    </div>
</div>