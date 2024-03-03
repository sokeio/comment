<?php

namespace Sokeio\Comment\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\File;
use Ip2location\IP2LocationLaravel\Facade\IP2LocationLaravel;

class View extends Model
{

    /**
     * @var string
     */
    protected $table = 'views';

    /**
     * @var string[]
     */
    protected $fillable = ['viewable_type', 'viewable_id', 'count'];
    /**
     * @return MorphTo
     */
    public function viewable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasMany
     */
    public function dates(): HasMany
    {
        return $this->hasMany(ViewDate::class);
    }
    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(ViewUser::class);
    }
    /**
     * @return false|int
     */
    public function isViewed(): bool|int
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
    public function AddView()
    {
        $ip = request()->ip();
        $country_code = 'other';
        if (File::exists(database_path('ip2location/IP2LOCATION.BIN'))) {
            $json = IP2LocationLaravel::get($ip);
            if ($json && isset($json['countryCode']) && $json['countryCode'] != 'This parameter is unavailable in selected .BIN data file. Please upgrade data file.') {
                $country_code = $json['countryCode'];
            }
        }
        $userAgent = request()->userAgent();
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $day = Carbon::now()->day;

        if (auth()->user()) {
            $this->users()->create([
                'user_id' => auth()->user()->id,
                'ip' => $ip,
                'user_agent' => $userAgent,
                'country_code' =>  $country_code
            ]);
        } else {
            $this->users()->create([
                'ip' => $ip,
                'user_agent' => $userAgent,
                'country_code' =>  $country_code
            ]);
        }
        $viewDate = $this->dates()->where('country_code', $country_code)->where('year', $year)->where('month', $month)->where('day', $day)->first();
        if ($viewDate) {
            $viewDate->count++;
            $viewDate->save();
        } else {
            $this->dates()->create([
                'ip' => $ip,
                'count' => 1,
                'user_agent' => $userAgent,
                'country_code' =>  $country_code,
                'year' => $year,
                'month' => $month,
                'day' => $day
            ]);
        }
        $this->count++;
        $this->save();
    }
}
