<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
use App\Models\Qualification;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    public function categories()
    {
        return $this->belongsToMany(Category::class,'product_categories'); 
    }
    public function qualification()
    {
        return $this->hasMany(Qualification::class,'product_id');
    }
}
