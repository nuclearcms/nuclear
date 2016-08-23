<div class="flash-messages" id="flashContainer">
    @if (session()->has('flash_notification.message'))
        <div class="flash-message flash-message--{{ session('flash_notification.level') }}">
            {{ session('flash_notification.message') }}
            <i class="flash-message__icon icon-status-{{ session('flash_notification.level') === 'danger' ? 'withheld' : 'published' }}"></i>
        </div>
    @endif
</div>
