@props(['msg', 'type'])
<div class="toastMsg">
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        {{ $msg }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>

