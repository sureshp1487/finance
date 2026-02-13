<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = "notes";
       protected $fillable = [
        'note',
        'status',
        'created_on',
        'is_delete'
    ];


}
