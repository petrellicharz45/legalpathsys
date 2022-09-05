<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ViewBook extends Model
{
    protected $fillable=[
        'user_id','book_id',
    ];

    public function library(){
        return $this->belongsTo(Library::class,'book_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    
}