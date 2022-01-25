<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public function product(){

        return $this->hasMany('App\Models\Product','photo_id');
        
      } 
      public function product_site(){

        return $this->hasMany('App\Models\Product_site','photo_id');
        
      } 
}
