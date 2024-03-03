<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Sokeio\Comment\Scopes\IpAndUserScopes;

class ViewUser extends Model
{

    use IpAndUserScopes;
    /**
     * @var string
     */
    protected $table = 'view_users';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];

    public $casts = [];
}
