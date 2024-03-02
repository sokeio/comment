<?php

namespace Sokeio\Comment\Scopes;

trait IpAndUserScopes
{

    /**
     * @param $query
     * @param  string  $ip
     * @return mixed
     */
    public function scopeForIp($query, string $ip): mixed
    {
        return $query->where('ip', $ip);
    }

    /**
     * @param $query
     * @param  string  $userAgent
     * @return mixed
     */
    public function scopeForUserAgent($query, string $userAgent): mixed
    {
        return $query->where('user_agent', $userAgent);
    }
}
