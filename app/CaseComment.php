<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseComment extends Model
{
    protected $fillable=[
        'story_id','name','email','phone','comment','file','status',
    ];

    public function blog(){
        return $this->belongsTo(Story::class);
    }
}
