<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
   
    protected $fillable = [
        'name','email','phone','cv','application','job_id',
    ];


    public function job(){
        return $this->belongsTo(Opportunity::class,'job_id');
    }

    

}
