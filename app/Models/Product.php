<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'goods';

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
