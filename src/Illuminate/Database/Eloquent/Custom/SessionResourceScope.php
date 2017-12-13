<?php

namespace Illuminate\Database\Eloquent\Custom;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

class SessionResourceScope implements Scope
{
    private $request;

    /**
     * SessionResourceScope constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  Builder $builder
     * @param  Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $token = $this->getBearerToken();
        $builder->where($model->getQualifiedSessionTokenColumn(), '=', $token);
    }

    /**
     * @return null|string
     */
    protected function getBearerToken()
    {
        return $this->request->bearerToken();
    }
}
