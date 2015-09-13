<div class="navigation-nodes-container material-light">

    <form id="search-nodes" method="post" action="/reactor/nodes/search">

        <input type="search" name="keywords" id="keywords" placeholder="{{ trans('validation.attributes.keywords') }}" required>
        <label class="icon-label" for="keywords">
            <i class="icon-search"></i>
        </label>

    </form>

    <div class="nodes-header">
        <h2>{{ trans('general.content') }}</h2>
        <a href="/reactor/nodes/create">
            <i class="icon-plus"></i>
        </a>
    </div>

</div>