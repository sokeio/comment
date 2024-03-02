<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Sokeio\Comment\Scopes\IpAndUserScopes;

class Action extends Model
{

    use IpAndUserScopes;
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
    public function scopeForType($query, string $type): mixed
    {
        return $query->where('type', $type);
    }

    /**
     * @return MorphTo
     */
    public function actionable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
