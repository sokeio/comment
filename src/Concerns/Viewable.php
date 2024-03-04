<?php

namespace Sokeio\Comment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sokeio\Comment\Models\View;

trait Viewable
{
    /**
     * @return MorphMany
     */
    public function views(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(View::class, 'viewable');
    }
    public function checkView()
    {
        if ($this->views) {
            if (!$this->views->isViewed()) {
                $this->views->AddView();
            }
        } else {
            $views = $this->views()->create(['count' => 0]);
            $views->AddView();
        }
    }
    public function viewCount()
    {
        if ($this->views) {
            return $this->views->count;
        }
        return 0;
    }
}
