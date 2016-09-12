<div class="modal {{ $containerClass or 'modal--content' }}">
    <div class="modal__whiteout">
        <div class="modal__inner">
            <h4 class="modal__heading">{!! $modalTitle or trans('general.warning') !!}</h4>

            <div class="modal__content">
                @if(isset($modalContent))
                    {{ $modalContent }}
                @else
                    @yield('modalContent')
                @endif
            </div>

            <div class="modal-buttons">
                @if(isset($modalButtons))
                    {!! $modalButtons !!}
                @else
                    @yield('modalButtons')
                @endif
            </div>
        </div>
    </div>
</div>