<ul class="content-list-dashboard">
@if(count($nodes))
    @foreach($nodes as $node)
        <li><a href="{{ $node->getDefaultLink() }}">
            {{ $node->translateOrFirst(null)->title }}
        </a></li>
    @endforeach
@else
    <li class="content-list-dashboard-empty">
        {{ trans('general.no_data') }}
    </li>
@endif
</ul>