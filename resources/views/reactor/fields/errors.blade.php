<ul class="form-group-errors">
    @foreach($errors->get($name) as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>