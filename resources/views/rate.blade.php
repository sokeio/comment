@php
    $rateTotal = 0;
    foreach ($rates as $key => $value) {
        # code...
        $rateTotal += $value;
    }
@endphp
<div class="d-inline-flex" x-data="{
    'unRatedIcon': '{{ $rateIcon['unRatedIcon'] ?? 'bi bi-star' }}',
    'halfRatedIcon': '{{ $rateIcon['halfRatedIcon'] ?? 'bi bi-star-half  text-warning' }}',
    'ratedIcon': '{{ $rateIcon['ratedIcon'] ?? 'bi bi-star-fill  text-warning' }}',
    chooseRate(_rate) {
        this.$wire.chooseRate(_rate);
    },
}">
    <div class="flex-column flex flex-grow-0">
        <div class="flex text-center fs-1 fw-bold p-3">
            <span>{{ $rate }}</span>/<span>{{ $rateMax }}</span>
        </div>
        <div class="mb-3 ms-4">
            @include('comment::partials.rate-item-hover', [
                'rate' => $userRate,
                'rateMax' => $rateMax,
            ])
        </div>
    </div>
    <div>
        @for ($i = 0; $i < $rateMax; $i++)
            @php
                $rateItem = isset($rates['rate-' . $i + 1]) ? $rates['rate-' . $i + 1] : 0;
            @endphp
            <div>
                @include('comment::partials.rate-item', [
                    'text' => $i + 1,
                    'rate' => $i + 1,
                    'rateMax' => $rateMax,
                    'afterText' => '(' . round($rateItem, 2) . ')',
                ])
            </div>
        @endfor
    </div>
</div>
