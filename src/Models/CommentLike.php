<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Sokeio\Comment\Scopes\IpAndUserScopes;

class CommentLike extends Model
{
    use IpAndUserScopes;

    /**
     * @var string
     */
    protected $table = 'comment_likes';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'ip',
        'user_agent',
    ];
}