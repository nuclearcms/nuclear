@extends('subscribers.base_edit')

@section('content')
    @include('subscribers.tabs', [
        'currentRoute' => 'reactor.subscribers.lists',
        'currentKey' => $subscriber->getKey()
    ])

    <div class="content-inner content-inner--compact">
        @include('mailing_lists.sublist', [
            'mailing_lists' => $subscriber->lists,
            'dissociateRoute' => route('reactor.subscribers.lists.dissociate', $subscriber->getKey())
        ])

        @if($count > 0)
        @include('mailing_lists.add')
        @endif
    </div>
@endsection

@include('partials.modals.delete_specific', ['message' => trans('mailing_lists.confirm_dissociate')])