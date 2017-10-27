<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Topic;
use App\Transformers\PostTransformer;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(StorePostRequest $request, Topic $topic)
    {
        $post = new Post;
        $post->body = $request->body;
        $this->updateThumbnail($request, $post);
        $post->user()->associate($request->user());

        $topic->posts()->save($post);

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function update(UpdatePostRequest $request, Topic $topic, Post $post)
    {
        $this->authorize('update', $post);

        $post->body = $request->get('body', $post->body);
        $this->updateThumbnail($request, $post);
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer())
            ->toArray();
    }

    public function destroy(Topic $topic, Post $post)
    {
        $this->authorize('destroy', $post);

        $post->delete();

        return response(null, 204);
    }

    /**
     * @param StorePostRequest $request
     * @param $post
     */
    protected function updateThumbnail(StorePostRequest $request, $post)
    {
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $name = $file->getClientOriginalName();
            $file->move(public_path() . '/images/', $name);
            $post->thumbnail = $name;
        }
    }
}
