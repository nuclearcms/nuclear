<form class="content-search-emphasized" method="GET" action="/{{ rtrim(request()->path(), '/') }}">
    <p>{{ trans('general.searched_for') }}:</p>
    <div class="form-group">
        <input type="search" name="q" id="q" placeholder="{{ trans('general.keywords') }}" value="{{ request('q') }}" required>
    </div>
    <p>{{ trans('general.found_results', ['count' => $result_count]) }}</p>
    <p class="muted">({{ trans('general.relevance_ordered') }})</p>
</form>