<?php

namespace Yormy\LaravelValidation\Traits;

trait Xid
{
    public static function bootXid()
    {
        static::creating(function ($model) {

            if (!$model->xid) {
                $model->xid = Xid();
            }
        });
    }
}
