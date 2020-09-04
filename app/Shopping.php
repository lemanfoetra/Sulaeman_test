<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shopping extends Model
{
    protected $table = "shopping";

    protected $fillable = [
        'name', 'crateddate',
    ];
}
