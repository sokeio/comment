<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Sokeio\Comment\Scopes\IpAndUserScopes;

class RateUser extends Model
{

    use IpAndUserScopes;
    /**
     * @var string
     */
    protected $table = 'rate_users';

    /**
     * @var string[]
     */
    protected $fillable = [
        'rate',
        'user_id',
        'ip',
        'user_agent',
    ];

}
