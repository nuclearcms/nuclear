@extends('mailings.base_edit')

@section('content')
    @include('mailings.tabs', [
        'currentRoute' => 'reactor.mailings.lists',
        'currentKey' => $mailing->getKey()
    ])

    <div class="content-inner content-inner--compact">
        <div class="content-inner__options">
            @include('mailings.options')
        </div>

        @include('mailing_lists.sublist_dispatch', [
            'mailing_lists' => $mailing->lists,
            'dissociateRoute' => route('reactor.mailings.lists.dissociate', $mailing->getKey())
        ])

        @if($count > 0)
        @include('mailing_lists.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete_specific', ['message' => trans('mailing_lists.confirm_dissociate')])