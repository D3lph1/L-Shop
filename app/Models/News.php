<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\News
 *
 * @property-read \App\Models\User $author
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
class News extends Model
{
    /**
     * @var string
     */
    protected $table = 'news';

    /**
     * @var array
     */
    protected $fillable = ['title', 'content', 'user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
