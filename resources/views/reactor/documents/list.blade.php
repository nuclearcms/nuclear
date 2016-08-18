<ul class="documents-list">
    @if($documents->count())
        @foreach($documents as $document)
            <li class="document">

                <div class="document__select">
                    {!! Form::checkbox('selected[]', $document->getKey(), false, ['class' => 'content-list__checkbox', 'id' => 'doc_' . $document->getKey()]) !!}
                    <label class="document__select-label" for="doc_{{ $document->getKey() }}">
                        <i class="document__select-icon icon-checkbox-checked"></i>
                        <i class="document__select-icon icon-checkbox-unchecked"></i>
                    </label>
                </div>

                {!! $document->present()->thumbnail !!}

                <p class="document__name">{{ $document->name }}</p>

                <div class="document__options">
                    <div class="document__option">
                        {!! action_button(route('reactor.documents.edit', $document->getKey()), 'icon-pencil', '', 'button--emphasis document__option-button') !!}
                    </div><form action="{{ route('reactor.documents.destroy', $document->getKey()) }}" method="POST" class="document__option delete-form">
                        {!! method_field('DELETE') . csrf_field() !!}
                        <button class="button button--danger document__option-button option-delete" type="submit"><i class="button__icon button__icon--action icon-trash"></i></button>
                    </form>
                </div>

            </li>
        @endforeach
    @else
        <li class="content-message">
            {{ trans('documents.no_documents') }}
        </li>
    @endif
</ul>