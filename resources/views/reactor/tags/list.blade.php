<ul class="tags-list">
    @if($tags->count())
        @foreach($tags as $tag)
        <li class="tag">

            <span class="tag__text">
                {!! link_to_route('reactor.tags.edit', $tag->title, [$tag->getKey(), $tag->translate()->getKey()]) !!}
            </span>

            <form action="{{ route('reactor.tags.destroy', $tag->getKey()) }}" method="POST" class="tag__option delete-form">
                {!! method_field('DELETE') . csrf_field() !!}
                <button class="option-delete" type="submit"><i class="tag__icon icon-trash"></i></button>
            </form>

            @if($tag->canHaveMoreTranslations())
            <span class="tag__option">
                <a href="{{ route('reactor.tags.translations.create', [$tag->getKey(), $tag->translate()->getKey()]) }}"><i class="tag__icon icon-language"></i></a>
            </span>
            @endif

        </li>
        @endforeach
    @else
        <li class="content-message">
            {{ trans('tags.no_tags') }}
        </li>
    @endif
</ul>