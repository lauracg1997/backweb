<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'position', 'cv_type', 'status', 'cv_url', 'location', 'duracion_meses'];
}
