<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    protected $table = 'foods';

    protected $fillable = [
        'name',
        'description',
        'price',
        'nutrition_facts',
        'category_id',
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
