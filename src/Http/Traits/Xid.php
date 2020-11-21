<?php

namespace App\Http\Traits;

trait Xid
{
    public static function bootXid()
    {
        static::creating(function ($model) {
            $model->xid = Xid();
        });
    }
}
