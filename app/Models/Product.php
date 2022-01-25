<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function marque() {

        return $this->belongsTo('App\Models\Marque');
   
    }
   
  
     public function image() {

        return $this->belongsTo('App\Models\Image','photo_id');
           
     }
}
