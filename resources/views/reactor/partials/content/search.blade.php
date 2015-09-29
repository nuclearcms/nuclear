<form class="content-search material-light" method="GET" action="/{{ rtrim(request()->path(), '/') }}/search">
    <i class="icon-search"></i>
    <input class="search-input" type="search" name="q" value="{{ request('q') }}" placeholder="{{ $placeholder }}">
</form>