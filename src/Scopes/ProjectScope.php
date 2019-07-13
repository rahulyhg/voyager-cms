<?php

namespace Tjventurini\VoyagerCMS\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class ProjectScope implements Scope
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
        // only show project related content via grpahql
        if (\Auth::user() && request()->getMethod() != 'POST') {
            $builder->whereHas('project', function ($query) {
                $query->whereHas('users', function ($query) {
                    $query->where(config('voyager-projects.foreign_keys.users'), \Auth::user()->id);
                });
            });
        }
    }
}
