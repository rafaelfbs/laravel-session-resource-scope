<?php

namespace Illuminate\Database\Eloquent\Custom;

use Illuminate\Container\Container;

trait SessionResource
{
    public static function bootSessionResource()
    {
        static::addGlobalScope(Container::getInstance()->make(SessionResourceScope::class));
    }

    public function getSessionTokenColumn()
    {
        return defined('static::SESSION_TOKEN_COLUMN') ? static::SESSION_TOKEN_COLUMN : 'session_token';
    }

    public function getQualifiedSessionTokenColumn()
    {
        return $this->getTable() . '.' . $this->getSessionTokenColumn();
    }
}
