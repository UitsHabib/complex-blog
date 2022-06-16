<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class PostRepository extends BaseRepository
{
    protected $modelName = Post::class;
}


