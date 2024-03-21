<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'user_id',
        'image_url',
        'details',
        'views',
        'title',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class ,  'topic_tags' , 'topic_id' , 'tag_id');
    }

    public function topicVotes()
    {
        return $this->hasMany(TopicVote::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
