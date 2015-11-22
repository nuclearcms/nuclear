<div class="modal-container {{ $containerClass or 'modal-content' }}">
    <div class="blackout">
        <div class="modal modal-{{ $type or 'notice' }}">
            <h4>{{ $modalTitle or trans('general.notice') }}</h4>

            <div class="modal-content">
                @if(isset($modalContent))
                    {{ $modalContent }}
                @else
                    @yield('modalContent')
                @endif
            </div>

            <div class="modal-buttons">
                @if(isset($modalButtons))
                    {{ $modalButtons }}
                @else
                    @yield('modalButtons')
                @endif
            </div>
        </div>
    </div>
</div>