<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime'
    ];

    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'body',
        'active',
        'published_at',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function getFormattedDate()
    {
        return $this->published_at->format('F jS Y');
    }

    public function shortBody(): string
    {
      return Str::words(strip_tags($this->body),30);
    }

    public function getThumbnail()
    {
        if (str_starts_with($this->thumbnail, 'http'))
        {
            return $this->thumbnail;
        }
        return 'storage/'.$this->thumbnail;
    }
}
