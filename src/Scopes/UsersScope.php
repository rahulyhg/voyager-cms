<?php

namespace Tjventurini\VoyagerCMS\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class UsersScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (\Auth::user() && \Auth::user()->role->name != 'admin') {
            $builder->whereHas('users', function ($query) {
                $query->where(config('voyager-projects.foreign_keys.users'), \Auth::user()->id);
            });
        }
    }
}
