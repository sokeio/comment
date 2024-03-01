<?php

namespace Sokeio\Comment\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Sokeio\Comment\Models\Action;

trait Actionable
{

    /**
     * @return MorphMany
     */
    public function actions(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Action::class, 'actionable');
    }
    public $typeActions = [
        'like' => [
            'icon' => 'bi bi-heart-fill',
            'text' => 'Like',
            'actionClass' => 'bg-primary text-white',
            'unactionClass' => '',
            'actionIconClass' => '',
            'unactionIconClass' => '',
        ],
        'favorites' => [
            'icon' => 'bi bi-star-fill',
            'text' => 'Favorites',
            'actionClass' => 'bg-primary text-white',
            'unactionClass' => '',
            'actionIconClass' => '',
            'unactionIconClass' => '',
        ],
    ];
    public function getTextIcon($type)
    {
        return isset($this->typeActions[$type]) ? $this->typeActions[$type] : null;
    }
    public function countActions($type = 'like')
    {
        return $this->actions()->forType($type)->count();
    }
    /**
     * @return false|int
     */
    public function isAction($type = 'like'): bool|int
    {
        if (auth()->user()) {
            return $this->actions()->where('user_id', auth()->user()->id)->forType($type)->count();
        }

        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if ($ip && $userAgent) {
            return $this->actions()->forIp($ip)->forUserAgent($userAgent)->forType($type)->count();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function removeAction($type = 'like'): bool
    {
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if (auth()->user()) {
            return $this->actions()->where('user_id', auth()->user()->id)->forType($type)->delete();
        }

        if ($ip && $userAgent) {
            return $this->actions()->forIp($ip)->forUserAgent($userAgent)->forType($type)->delete();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function addAction($type = 'like'): bool
    {
        if (auth()->user()) {
            $this->actions()->create([
                'user_id' => auth()->id(),
                'type' => $type,
            ]);
            return true;
        }
        $ip = request()->ip();
        $userAgent = request()->userAgent();
        if ($ip && $userAgent) {
            $this->actions()->create([
                'ip' => $ip,
                'user_agent' => $userAgent,
                'type' => $type,
            ]);
            return true;
        }

        return false;
    }
}
