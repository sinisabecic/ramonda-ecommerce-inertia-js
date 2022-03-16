<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    // new way for defining slug
    use SoftDeletes, Sluggable;

    protected $table = 'category';
    protected $guarded = [];
    protected $dates = ['deleted_at'];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product')
            ->withPivot('created_at');
    }

//    public function setNameAttribute($value)
//    {
//        $this->attributes['name'] = $value;
//        $this->attributes['slug'] = Str::slug($value);
//    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
