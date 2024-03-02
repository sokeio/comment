@php
    $rateRound = round($rate);
@endphp
<div class="d-inline-flex flex-row align-items-center" x-data="{
    rate: {{ $rate }},
    rateRound: {{ $rateRound }},
    rateMax: {{ $rateMax }},
    currentRate: {{ $rate }},
    hoverIcon: false,
    getClassIcon(_rate) {
        if (this.hoverIcon && this.currentRate !== this.rate) {
            if (_rate <= this.currentRate) {
                return this.ratedIcon;
            }
            return this.unRatedIcon;
        }
        if (_rate <= this.rateRound) {
            return this.ratedIcon;
        } else if (_rate <= this.rateRound + 0.5) {
            return this.halfRatedIcon;
        } else {
            return this.unRatedIcon;
        }
    }
}">
    @if (isset($text))
        <div class="me-3">{{ $text }}.</div>
    @endif
    <div class="me-3 flex flex-row text-center">
        @for ($i = 0; $i < $rateMax; $i++)
            @if ($i < $rateRound)
                <i :class="ratedIcon"></i>
            @elseif($i < $rateRound + 0.5)
                <i :class="halfRatedIcon"></i>
            @else
                <i :class="unRatedIcon"></i>
            @endif
        @endfor
    </div>
    @if ((isset($afterText) && $afterText))
        <div class="flex flex-row align-items-center ">
            {{ $afterText }}
        </div>
    @endif
</div>
