<div class="pagination-container">
    @if ($paginator->lastPage() > 1)
    <div class="pagination">

        @if($paginator->currentPage() === 1)
        <span class="pagination__sibling pagination__sibling--disabled">
            <i class="icon-arrow-left"></i>
        </span>
        @else
        <a class="pagination__sibling" href="{{ $paginator->url(1) }}">
            <i class="icon-arrow-left"></i>
        </a>
        @endif

        <div class="pagination__current-container">
            <span class="pagination__current">
                {{ uppercase(trans('general.page')) . ' ' . $paginator->currentPage() . '/' . $paginator->lastPage() }}
            </span>

            <select class="pagination__selector">
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <option value="{{ $paginator->url($i) }}"{{ $paginator->currentPage() === $i ? ' selected="selected"': '' }}>{{ $i }}</option>
            @endfor
            </select>

        </div>

        @if($paginator->currentPage() === $paginator->lastPage())
        <span class="pagination__sibling pagination__sibling--disabled">
            <i class="icon-arrow-right"></i>
        </span>
        @else
        <a class="pagination__sibling" href="{{ $paginator->url($paginator->currentPage() + 1) }}">
            <i class="icon-arrow-right"></i>
        </a>
        @endif
    </div>
    @endif
</div>