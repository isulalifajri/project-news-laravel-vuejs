<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     protected $fillable = [
        'title', 'slug', 'content', 'thumbnail',
        'status', 'published_at', 'category_id', 'user_id'
     ];

     public function category()
     {
         return $this->belongsTo(Category::class);
     }

     public function backendUser()
     {
         return $this->belongsTo(BackendUser::class, 'user_id');
     }

     public function comments()
     {
         return $this->hasMany(Comment::class);
     }

     public function tags()
     {
         return $this->belongsToMany(Tag::class);
     }
}
