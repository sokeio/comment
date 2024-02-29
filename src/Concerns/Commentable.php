<?php

namespace Sokeio\Comment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sokeio\Comment\Models\Comment;

trait Commentable
{

    /**
     * @return MorphMany
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}