<?php
declare(strict_types = 1);

namespace App\Models\News;

use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\News\EloquentNews
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User\EloquentUser $author
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\News\EloquentNews whereUserId($value)
 * @mixin \Eloquent
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */
class EloquentNews extends Model implements NewsInterface
{
    /**
     * @var string
     */
    protected $table = 'news';

    /**
     * @var array
     */
    protected $fillable = ['title', 'content', 'user_id'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(EloquentUser::class, 'user_id', 'id');
    }

    public function getUser(): UserInterface
    {
        return $this->author;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): NewsInterface
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setContent(string $content): NewsInterface
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setUserId(string $userId): NewsInterface
    {
        $this->user_id = $userId;

        return $this;
    }

    public function getUserId(): int
    {
        return $this->user_id;
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
