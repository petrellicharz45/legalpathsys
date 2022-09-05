<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $fillable=[
        'case_category_id','title','description','image','status','user_id',
    ];

    public function category(){
        return $this->belongsTo(CaseCategory::class,'case_category_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(CaseComment::class);
    }
}
