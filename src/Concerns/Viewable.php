<?php

namespace Sokeio\Comment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sokeio\Comment\Models\View;

trait Viewable
{
    /**
     * @return MorphMany
     */
    public function view(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(View::class, 'viewable');
    }
    public function checkView()
    {
        if ($this->view) {
            if (!$this->view->isViewed()) {
                $this->view->AddView();
            }
        } else {
            $view = $this->view()->create(['count' => 0]);
            $view->AddView();
        }
    }
    public function viewCount()
    {
        if ($this->view) {
            return $this->view->count;
        }
        return 0;
    }
}
