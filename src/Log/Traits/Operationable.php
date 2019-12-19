<?php

namespace Studiosidekicks\Alfred\Log\Traits;

use Studiosidekicks\Alfred\Core\Contracts\AlfredModelContract;
use Sentinel;
use Studiosidekicks\Alfred\Log\Entities\LogOperation;

trait Operationable
{
    public static function bootOperationable()
    {
        static::created(function (AlfredModelContract $alfredModel) {
            self::createOperation($alfredModel, 'created');
        });

        static::updated(function (AlfredModelContract $alfredModel) {
            self::createOperation($alfredModel, 'updated');
        });

//        static::published(function (AlfredModelContract $alfredModel) {
//            self::createOperation($alfredModel, 'published');
//        });
//
//        static::unpublished(function (AlfredModelContract $alfredModel) {
//            self::createOperation($alfredModel, 'unpublished');
//        });

        static::deleted(function (AlfredModelContract $alfredModel) {
            self::createOperation($alfredModel, 'deleted');
        });
    }

    private static function createOperation(AlfredModelContract $alfredModel, $action)
    {
        $user = Sentinel::getUser();

        $alfredModel->operations()->create([
            'language_id' => 1,//$alfredModel->language_id,TODO:implement
            'email' => $user ? $user->email : (request()->filled('email') ? request()->get('email') : ''),
            'user_id' => $user ? $user->id : null,
            'action' => $action,
        ]);
    }

    public function operations()
    {
        return $this->morphMany(LogOperation::class, 'item');
    }
}