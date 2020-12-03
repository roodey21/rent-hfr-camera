<?php

namespace App\Models;

use App\Models\Brand;
use App\Models\Category;
use App\Models\PriceProduct;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model implements HasMedia
{
    use HasFactory, Sluggable, InteractsWithMedia;

    protected $guarded = ['id'];

    
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }
    public function prices()
    {
        return $this->hasMany(PriceProduct::class);
    }
}
