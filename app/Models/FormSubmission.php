<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = ['name', 'surname', 'email', 'phone', 'company', 'cargo', 'employees', 'message', 'source', 'resource_name', 'status'];
}
