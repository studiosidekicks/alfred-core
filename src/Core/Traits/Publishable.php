<?php

namespace Studiosidekicks\Alfred\Core\Traits;

trait Publishable
{
    protected $observables = [
        'published',
        'unpublished'
    ];

    public function publish()
    {
        $this->fireModelEvent('published', false);
    }

    public function unPublish()
    {
        $this->fireModelEvent('unpublished', false);
    }
}