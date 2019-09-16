<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maker extends Model
{
    public function goods()
    {
        return $this->hasMany(Good::class);
    }
}
