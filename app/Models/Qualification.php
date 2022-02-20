<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Qualification extends Model
{
    protected $table = 'qualification';
    use HasFactory;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
