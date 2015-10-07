@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }} material-light">
        {{ session('flash_notification.message') }}
    </div>
@endif