<ul class="progress">
    @for($i = 1; $i <= 6; $i++)
        @if($i < $step)
            <li class="progress__item progress__item--complete"></li>
        @elseif($i === $step)
            <li class="progress__item progress__item--active"></li>
        @else
            <li class="progress__item"></li>
        @endif
    @endfor
</ul>