<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Models
 */
class Server extends Model
{
    protected $table = 'servers';

    public function categories()
    {
        return $this->hasMany(Category::class, 'server_id', 'id');
    }
}
