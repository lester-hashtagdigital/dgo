<?php
/**
 * Created by PhpStorm.
 * User: Lester Hurtado
 * Date: 10/18/17
 * Time: 10:38 AM
 */

namespace App\Transformers;

use App\Post;

class PostTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = ['user', 'likes'];

    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'body' => $post->body,
            'like_count' => $post->likes->count(),
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    public function includeLikes(Post $post)
    {
        return $this->collection($post->likes->pluck('user'), new UserTransformer);
    }
}