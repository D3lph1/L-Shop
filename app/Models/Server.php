<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';

    public function categories()
    {
        return $this->hasMany(Category::class, 'server_id', 'id');
    }
}
