<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['post_id','user_id','content','parent_id'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }

    // komentar utama bisa punya banyak balasan
    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // balasan tahu komentar induknya
    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }


}
