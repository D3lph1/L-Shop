<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Models
 */
class Item extends Model
{
    protected $fillable = ['name', 'description', 'type', 'item', 'image', 'extra'];

    /**
     * @var string
     */
    protected $table = 'items';
}
