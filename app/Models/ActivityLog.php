<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = ['type', 'description'];

    public static function log(string $type, string $description): void
    {
        static::create(['type' => $type, 'description' => $description]);
    }
}
