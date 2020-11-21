<?php

namespace Yormy\LaravelValidation\Traits;

trait Xid
{
    public static function bootXid()
    {
        static::creating(function ($model) {
            $model->xid = Xid();
        });
    }
}
