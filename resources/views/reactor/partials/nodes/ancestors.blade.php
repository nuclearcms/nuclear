@if(count($ancestors))
    <div class="content-ancestors">
        <h4>{{ uppercase(trans('nodes.ancestors')) }}</h4>
        {!! implode(
            '<i class="icon-right-thin"></i>',
            ancestor_links($ancestors)
       ) !!}
    </div>
@endif