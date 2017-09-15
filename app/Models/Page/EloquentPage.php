<?php
declare(strict_types = 1);

namespace App\Models\Page;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Page whereUrl($value)
 */
class EloquentPage extends Model implements PageInterface
{
    protected $table = 'pages';

    protected $fillable = [
        'title',
        'content',
        'url'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updated_at;
    }
}
