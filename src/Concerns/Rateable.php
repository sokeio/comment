<?php

namespace Sokeio\Comment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sokeio\Comment\Models\Rate;

trait Rateable
{
    /**
     * @return MorphMany
     */
    public function rate(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Rate::class, 'rateable');
    }
    public $rateMax = 5;
    public $rateIcon = [
        'unRated' => 'bi bi-star',
        'halfRated' => 'bi bi-star-half text-warning',
        'rated' => 'bi bi-star-fill text-warning',
    ];
    public function changeRate($rate, $rateMax)
    {
        if ($this->rate != null) {
            $this->rate->changeRate($rate, $rateMax);
        } else {
            $rate =  $this->rate()->create([
                'rate' => $rate,
                'rates' => [
                    'rate-' . $rate => 1
                ]
            ]);
            $rate->addUserRate($rate);
        }
    }
}
