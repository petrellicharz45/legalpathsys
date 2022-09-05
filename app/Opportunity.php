<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $fillable=[
        'title','company','apply_link','quick_apply','description','closing_date','file','status','company','file','salary','position','type_id','user_id',
    ];

    public function type(){
        return $this->belongsTo(Opportunitytype::class,'type_id');
    }


    public function lawyer(){
        return $this->hasMany(Lawyer::class,'user_id');
    }

    public function legalofficer(){
        return $this->hasMany(Legaloffice::class,'user_id');
    }
}