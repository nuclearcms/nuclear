{!! content_table_open(true) !!}

    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('title', uppercase(trans('validation.attributes.title'))) !!}
    </th>
    <th class="content-list__cell content-list__cell--secondary content-list__cell--head">
        {{ uppercase(trans('validation.attributes.type')) }}
    </th>
    <th class="content-list__cell content-list__cell--head">
        {!! sortable_link('created_at', uppercase(trans('validation.attributes.created_at'))) !!}
    </th>

{!! content_table_middle() !!}

    @if($nodes->count())
        @foreach($nodes as $node)
            <tr class="content-list__row--body">

                <td class="content-list__cell">
                    {!! link_to($node->getDefaultEditUrl($locale), $node->translateOrFirst($locale)->title) !!}
                </td>

                <td class="content-list__cell content-list__cell--secondary">
                    {{ $node->getNodeType()->label }}
                </td>

                <td class="content-list__cell">
                    {{ $node->created_at->formatLocalized('%b %e, %Y') }}
                </td>

                {!! node_options($node) !!}

            </tr>
        @endforeach
    @else
        {!! no_results_row('nodes.no_nodes') !!}
    @endif

{!! content_table_close(true) !!}

<div class="content-footer content-footer--sub">
    @include('partials.contents.pagination', ['paginator' => $nodes, 'paginationModifier' => 'pagination--inpage'])
</div>
