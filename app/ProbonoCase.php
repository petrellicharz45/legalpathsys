<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProbonoCase extends Model
{
    protected $fillable=[
        'case_category_id','title','description','image','status','show_feature_probono',
    ];

    public function category(){
        return $this->belongsTo(CaseCategory::class,'case_category_id');
    }

    public function comments(){
        return $this->hasMany(CaseComment::class);
    }
}
