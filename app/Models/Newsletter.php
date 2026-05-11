<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = ['name', 'subject', 'content', 'status', 'subscribers', 'last_sent_at', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime', 'last_sent_at' => 'date'];
}
