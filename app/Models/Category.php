<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'categories';
    protected $guarded = ['id'];

    public function sluggable()
    {
        return [
            'slug'  =>  [
                'source'    =>  'name',
            ]
        ];
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeGetParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
