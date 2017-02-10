<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';

    public function item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
}
