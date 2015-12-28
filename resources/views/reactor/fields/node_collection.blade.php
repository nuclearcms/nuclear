{!! field_wrapper_open($options, $name, $errors, 'form-group-node-collection') !!}

<div class="form-group-column form-group-column-field">
    {!! field_label($showLabel, $options, $name) !!}

    @if($collection = get_nodes_by_ids($options['value'], false))
    <div class="form-nodes-container">
        <ul class="form-nodes-list form-nodes-list-sortable material-light">
        @foreach($collection as $node)
            <li data-id="{{ $node->getKey() }}">
                {!! $node->title !!}
                <i class="icon-cancel"></i>
            </li>
        @endforeach
    @else
    <div class="form-nodes-container empty">
        <ul class="form-nodes-list form-nodes-list-sortable material-light">
    @endif
        </ul>
        <div class="form-nodes-search" data-searchurl="{{ route('reactor.contents.json.search') }}">
            <input type="text" name="_nodesearch" placeholder="{{ trans('nodes.search') }}" autocomplete="off">
            <ul class="form-nodes-list form-nodes-list-results material-middle">

            </ul>
        </div>
        {!! Form::hidden($name, $options['value'], $options['attr']) !!}
    </div>
    {!! field_errors($errors, $name) !!}

</div>{!! field_help_block($name, $options) !!}

{!! field_wrapper_close($options) !!}