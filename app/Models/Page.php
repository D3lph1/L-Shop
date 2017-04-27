<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Models
 */
class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['title', 'content', 'url'];
}
