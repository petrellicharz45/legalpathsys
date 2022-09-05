<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseCategory extends Model
{
    protected $fillable=[
        'name','slug','status'
    ];
}
