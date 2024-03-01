<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{

    /**
     * @var string
     */
    protected $table = 'actions';

    /**
     * @var string[]
     */
    protected $fillable = [
        'actionable_type',
        'actionable_id',
        'type',
        'user_id',
        'ip',
        'user_agent',
    ];


    /**
     * @param $query
     * @param  string  $ip
     * @return mixed
     */
    public function scopeForIp($query, string $ip): mixed
    {
        return $query->where('ip', $ip);
    }
    /**
     * @param $query
     * @param  string  $ip
     * @return mixed
     */
    public function scopeForType($query, string $type): mixed
    {
        return $query->where('type', $type);
    }

    /**
     * @param $query
     * @param  string  $userAgent
     * @return mixed
     */
    public function scopeForUserAgent($query, string $userAgent): mixed
    {
        return $query->where('user_agent', $userAgent);
    }
    /**
     * @return MorphTo
     */
    public function actionable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
