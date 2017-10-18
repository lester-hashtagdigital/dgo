<?php

/**
 * Created by PhpStorm.
 * User: Lester Hurtado
 * Date: 10/18/17
 * Time: 9:37 AM
 */
namespace App\Traits;

trait Orderable
{
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}
