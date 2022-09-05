<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $fillable=[
        'book_title','author','pdf','description','category','type','image','show_homepage','view_count',
    ];
}
