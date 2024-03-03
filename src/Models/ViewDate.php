<?php

namespace Sokeio\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class ViewDate extends Model
{

    /**
     * @var string
     */
    protected $table = 'view_dates';

    /**
     * @var string[]
     */
    protected $fillable = [
        'count',
        'country_code',
        'year',
        'month',
        'day',
    ];

    public $casts = [];
}
