<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'price',
        'discount',
        'stock',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('name')) {
                $slug = Str::slug($model->name);

                $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

                $model->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }
}
