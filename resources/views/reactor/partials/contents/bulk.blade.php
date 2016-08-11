{!! header_action_open('general.bulk_actions', 'header__action--left header__action--bulk header__action--hidden') !!}
<button class="button button--action button--select-none">
    <i class="button__icon button__icon--action icon-checkbox-unchecked"></i>
</button><button class="button button--action button--separated button--select-all">
    <i class="button__icon button__icon--action icon-checkbox-checked"></i>
</button><form action="{{ route('reactor.' . $key . '.destroy.bulk') }}" method="POST">{!! method_field('DELETE') . csrf_field() !!}<button class="button button--danger button--bulk-delete">
        <i class="button__icon button__icon--action icon-trash"></i>
    </button><input type="hidden" name="_bulkSelected" value="[]"></form>
{!! header_action_close() !!}