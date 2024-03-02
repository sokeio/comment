<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rate extends Model
{

    /**
     * @var string
     */
    protected $table = 'rates';

    /**
     * @var string[]
     */
    protected $fillable = [
        'rateable_type',
        'rateable_id',
        'rate',
        'rates',
    ];
    public $casts = [
        'rates' => 'array',
        'rate' => 'decimal:2',
    ];
    /**
     * @return MorphTo
     */
    public function rateable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function users(): HasMany
    {
        return $this->hasMany(RateUser::class);
    }
    public function getRated()
    {

        if (auth()->user()) {
            return $this->users()->where('user_id', auth()->user()->id)->first();
        }

        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if ($ip && $userAgent) {
            return $this->users()->forIp($ip)->forUserAgent($userAgent)->first();
        }
        return null;
    }
    public function getUserRateCurrent()
    {
        $userRated = $this->getRated();
        if ($userRated) {
            return $userRated->rate;
        }
        return 0;
    }
    /**
     * @return false|int
     */
    public function isRated(): bool|int
    {
        if (auth()->user()) {
            return $this->users()->where('user_id', auth()->user()->id)->count();
        }

        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if ($ip && $userAgent) {
            return $this->users()->forIp($ip)->forUserAgent($userAgent)->count();
        }
        return false;
    }
    public function addUserRate($rate): RateUser
    {

        if (auth()->user()) {
            return $this->users()->create([
                'rate' => $rate,
                'user_id' => auth()->user()->id
            ]);
        }

        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if (!auth()->user() && $ip && $userAgent) {
            return $this->users()->create([
                'rate' => $rate,
                'ip' => $ip,
                'user_agent' => $userAgent
            ]);
        }
        return null;
    }
    public function changeRate($rate, $rateMax)
    {
        $userRated = $this->getRated();
        $oldRated = 0;
        if ($userRated) {
            $oldRated = $userRated->rate;
            $userRated->update([
                'rate' => $rate
            ]);
        } else {
            $userRated = $this->addUserRate($rate);
        }
        $rates = $this->rates;
        for ($i = 1; $i <= $rateMax; $i++) {
            if (!isset($rates['rate-' . $i])) {
                $rates['rate-' . $i] = 0;
            }
            if ($rates['rate-' . $i] < 0) {
                $rates['rate-' . $i] = 0;
            }
        }
        if ($oldRated > 0 && $oldRated <= $rateMax) {
            $rates['rate-' . $oldRated]--;
            if ($rates['rate-' . $oldRated] < 0) {
                $rates['rate-' . $oldRated] = 0;
            }
        }

        $rates['rate-' . $rate]++;
        $userRateTotal = 0;
        $rateTotal = 0;
        for ($i = 1; $i <= $rateMax; $i++) {
            $rateTotal += $rates['rate-' . $i];
            $userRateTotal += ($i * $rates['rate-' . $i]);
        }
        $this->rate =  $rateTotal ? ($userRateTotal / $rateTotal) : 0;
        $this->rates = $rates;
        $this->save();
    }
}
