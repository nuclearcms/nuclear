@extends('layout.' . ((isset($_withForm) && $_withForm === true) ? 'form' : 'content'))

@section('pageSubtitle')
    {!! link_to_route('reactor.mailings.index', uppercase(trans('mailings.title'))) !!}
@endsection

@section('header_content')
    @include('partials.contents.header', [
        'headerTitle' => $mailing->translateOrFirst()->title,
        'headerHint' => link_to_route('reactor.nodetypes.edit', uppercase($mailing->getNodeTypeName()), $mailing->getNodeType()->getKey())
    ])
@endsection