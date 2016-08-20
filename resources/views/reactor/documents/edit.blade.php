@extends('documents.base_edit')

@section('content')
    {!! $document->present()->preview !!}

    <div class="content-inner">
        <div class="form-column form-column--full">
            {!! form_until($form, 'public_url') !!}

            @if(locale_count() > 1)
            <div class="tabs-container">
                <div class="sub-tab-flaps tabs-outer tabs-outer--sub scroller scroller--muted">
                    <ul class="tabs">
                        <?php $i = 0; ?>
                        @foreach(locales() as $locale)
                        <li class="tabs__flap">
                            <span class="tabs__link{{ $i === 0 ? ' tabs__link--active' : '' }}" data-locale="{{ $locale }}">{{ uppercase(trans($locale)) }}</span>
                        </li>
                        <?php $i++; ?>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <div class="sub-tabs">
                <?php $i = 0; ?>
                @foreach(locales() as $locale)
                <div class="sub-tab{{ $i === 0 ? ' sub-tab--active' : '' }}" data-locale="{{ $locale }}">
                    {!! form_row($form->{$locale}) !!}
                </div>
                <?php $i++; ?>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('form_buttons')
    @can('EDIT_DOCUMENTS')
    {!! submit_button('icon-floppy') !!}
    @endcan
@endsection