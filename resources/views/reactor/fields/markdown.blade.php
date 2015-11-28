{!! field_wrapper_open($options, $name, $errors, 'form-group-markdown') !!}

<?php $toolsets = [
    ['bold' => 'bold', 'italic' => 'italic'],
    ['quote-left' => 'quote', 'list-bullet' => 'list', 'header' => 'heading'],
    ['link' => 'link', 'picture' => 'media'],
    ['code' => 'code', 'minus' => 'hrule', 'ellipsis' => 'readmore']
]; ?>

{!! field_label($showLabel, $options, $name) !!}

<div class="markdown-editor">
    <ul class="markdown-editor-toolbar">
        @foreach($toolsets as $toolset)
            <li class="toolset">
                <ul>
                    @foreach($toolset as $icon => $tool)
                        <li title="{{ trans('nodes.tool_' . $tool) }}" data-method="{{ $tool }}"><i class="icon-{{ $icon }}"></i></li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>

    {!! Form::textarea($name, $options['value'], $options['attr']) !!}

</div>


{!! field_errors($errors, $name) !!}

{!! field_wrapper_close($options) !!}