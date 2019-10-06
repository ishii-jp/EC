<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    protected $fillable = [
        'name', 'kana', 'category_id', 'maker_id', 'price', 'stock','good_details'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function maker()
    {
        return $this->belongsTo(Maker::class);
    }
}
