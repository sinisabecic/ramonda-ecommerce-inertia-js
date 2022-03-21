<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{

    protected $table = 'category_product';

    protected $fillable = ['product_id', 'category_id'];
    protected $dates = ['created_at', 'deleted_at'];


}
