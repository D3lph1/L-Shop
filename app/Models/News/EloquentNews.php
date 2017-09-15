<?php
declare(strict_types = 1);

namespace App\Models\News;

use App\Models\User\EloquentUser;
use App\Models\User\UserInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\News
 *
 * @property-read UserInterface $author
 * @mixin \Eloquent
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\News whereUserId($value)
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
