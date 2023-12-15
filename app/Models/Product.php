<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    const IS_FLAVOURED_YES = 1;
    const IS_FLAVOURED_NO = 0;

    const IS_SEASONAL_YES = 1;
    const IS_SEASONAL_NO = 0;

    const IS_INSTOCK_YES = 1;
    const IS_INSTOCK_NO = 0;
    
    const IS_K_CUP_YES = 1;
    const IS_K_CUP_NO = 0;

    const NO = 0;
    const YES = 1;


    //ORM
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
