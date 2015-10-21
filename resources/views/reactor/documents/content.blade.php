<ul class="document-list">
    @foreach($documents as $document)
        <li class="document material-light">
            <div class="document-thumbnail">
                {!! $document->present()->thumbnail !!}
            </div>
            <p class="document-name">
                {!! link_to_route('reactor.documents.edit', $document->name, $document->getKey()) !!}
            </p>
            <span class="document-options content-item-options">
                <button class="content-item-options-button">
                    <i class="icon-ellipsis-vert"></i>
                </button>
                <ul class="content-item-options-list material-middle">
                    <li class="list-header">{{ uppercase(trans('general.options')) }}</li>
                    <li>
                        <a href="{{ route('reactor.documents.edit', $document->getKey()) }}">
                            <i class="icon-pencil"></i> {{ trans('documents.edit') }}</a>
                    </li>
                    <li>
                        {!! delete_form(
                            route('reactor.documents.destroy', $document->getKey()),
                            trans('documents.delete')
                        ) !!}
                    </li>
                </ul>
            </span>
        </li>
    @endforeach
</ul>