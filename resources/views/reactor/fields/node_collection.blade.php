{!! field_wrapper_open($options, $name, $errors, 'form-group-node-collection') !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    @if($collection = get_nodes_by_ids($options['value'], false))
    <div class="form-nodes-container">
        <ul class="form-items-list form-items-list-sortable material-light">
        @foreach($collection as $node)
            <li data-id="{{ $node->getKey() }}">
                {!! $node->title !!}
                <i class="icon-cancel"></i>
            </li>
        @endforeach
    @else
    <div class="form-nodes-container empty">
        <ul class="form-items-list form-items-list-sortable material-light">
    @endif
        </ul>
        <div class="form-items-search"
             data-searchurl="{{ route('reactor.contents.search.json') }}"
             data-nodetype="{!! isset($options['node_type']) ? $options['node_type'] : 'all' !!}">
            <input type="text" name="_nodesearch" placeholder="{{ trans('nodes.search') }}" autocomplete="off">
            <ul class="form-items-list form-items-list-results material-middle">

            </ul>
        </div>
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>
    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}