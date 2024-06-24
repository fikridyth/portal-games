<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/games/' . $image),
        );
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
