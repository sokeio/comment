<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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
    public function users(): HasMany
    {
        return $this->hasMany(ViewUser::class);
    }
}
