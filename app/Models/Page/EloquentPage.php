<?php
declare(strict_types = 1);

namespace App\Models\Page;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Page\EloquentPage
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page\EloquentPage whereUrl($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
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
