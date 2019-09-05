<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = [
        'name', 'kana', 'category_id', 'maker_id', 'price', 'stock'
    ];
}
