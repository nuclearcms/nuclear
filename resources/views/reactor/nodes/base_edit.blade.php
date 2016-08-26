@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.nodes.index', uppercase(trans('nodes.title'))) !!}
@endsection

@section('header_content')
    @if(count($ancestors = $node->getAncestors()))
        <div class="breadcrumbs">
            <h4 class="breadcrumbs__heading">{{ uppercase(trans('nodes.ancestors')) }}</h4>
            <div class="breadcrumbs__links">
                {!! implode(
                    '<i class="breadcrumbs__icon icon-arrow-right"></i>',
                    ancestor_links($ancestors)
               ) !!}
            </div>
        </div>
    @endif

    @include('partials.contents.header', [
        'headerTitle' => $source->title,
        'headerHint' => link_to_route('reactor.nodetypes.edit', uppercase($node->getNodeTypeName()), $node->getNodeType()->getKey())
    ])
@endsection

@if(isset($_withForm) && $_withForm === true)
@section('scripts')
    @parent
    <script>
        $('.button--publisher').on('click', function() {
            var form = $(this).closest('form');
            $('<input name="_publish" value="publish">').appendTo(form);
            form.submit();
        });
    </script>
@endsection
@endif