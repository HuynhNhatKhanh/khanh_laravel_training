<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['title', 'content', 'votes'];

    public function FeaturedImages(){
        return $this->hasOne(FeaturedImages::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}


