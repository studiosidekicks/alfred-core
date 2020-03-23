<?php

namespace Studiosidekicks\Alfred\Auth\Back\Entities;

use Cartalyst\Sentinel\Roles\EloquentRole;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Role extends EloquentRole
{
    use HasSlug;

    protected $appends = ['is_deletable'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getIsDeletableAttribute()
    {
        return !$this->users()->exists();
    }
}
