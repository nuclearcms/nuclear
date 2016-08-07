<p class="auth-message text--sm text--danger">
    @if(count($errors) > 0)
        @foreach($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    @endif
</p>