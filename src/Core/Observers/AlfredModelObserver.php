<?php

namespace Studiosidekicks\Alfred\Core\Observers;

use Studiosidekicks\Alfred\Core\Contracts\AlfredModelContract;

class AlfredModelObserver
{
    public function created(AlfredModelContract $alfredModel)
    {
        $this->createOperation($alfredModel, 'created');
    }

    public function updated(AlfredModelContract $alfredModel)
    {
        $this->createOperation($alfredModel, 'updated');
    }

    public function published(AlfredModelContract $alfredModel)
    {
        $this->createOperation($alfredModel, 'published');
    }

    public function unpublished(AlfredModelContract $alfredModel)
    {
        $this->createOperation($alfredModel, 'unpublished');
    }

    public function deleted(AlfredModelContract $alfredModel)
    {
        $this->createOperation($alfredModel, 'deleted');
    }

    private function createOperation(AlfredModelContract $alfredModel, $action)
    {
        $alfredModel->operations()->create([
            'language_id' => $alfredModel->language_id,
            'email' => '',
            'user_id' => '',
            'action' => $action,
        ]);
    }
}