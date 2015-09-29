{!! with(new Reactor\Http\Presenters\Pagination\PaginationPresenter(
    $pagination->appends(request()->except(['page']))
))->render() !!}