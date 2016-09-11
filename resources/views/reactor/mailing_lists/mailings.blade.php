@extends('mailing_lists.base_edit')

@section('content')
    @include('mailing_lists.tabs', [
        'currentRoute' => 'reactor.mailing_lists.mailings',
        'currentKey' => $mailing_list->getKey()
    ])

    <div class="content-inner content-inner--xcompact">
        @include('nodes.sublist', ['locale' => null, 'nodes' => $mailings, 'noResultsMessage' => 'mailings.no_mailings'])
    </div>
@endsection