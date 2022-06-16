<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\PostRepository;

class PostService
{
    private $postRepository;

    public function __construct(PostRepository $postRepository){

        $this->postRepository = $postRepository;
    }

    public function getAll(){
        try {
            $posts =  $this->postRepository->getAll();

            return [
                'status' => 200,
                'posts' => $posts
            ];
        }catch (\Exception $e){
            return [
                'status' => 500,
                'message' => 'Server Error',
            ];
        }

    }

    public function save($data){
        try {
            $post =  $this->postRepository->save($data);

            return [
                'status' => 200,
                'message' => 'Post Created Successfully',
                'post' => $post
            ];
        }catch (\Exception $e){
            return [
                'status' => 400,
                'message' => 'Post Created Failed',
            ];
        }
    }

    public function update($postId, $data){
        try {
            $post = Post::find($postId);

            if(is_null($post)){
                return [
                    'status' => 404,
                    'message' => 'Data Not Found',
                ];
            }
            $post =  Post::where('id', $postId)->update($data);
            return [
                'status' => 200,
                'message' => 'Post Updated Successfully',
                'post' => $data
            ];
        }catch (\Exception $e){
            return [
                'status' => 400,
                'message' => 'Post Updated Failed',
            ];
        }
    }

    public function delete($postId){

        try {
            $post = Post::find($postId);
            $post = Post::find($postId);

            if(is_null($post)){
                return [
                    'status' => 404,
                    'message' => 'Data Not Found',
                ];
            }

            $data = $post;
            $post->delete();

            return [
                'status' => 200,
                'message' => 'Post Deleted Successfully',
                'post' => $data
            ];
        }catch (\Exception $e){
            return [
                'status' => 400,
                'message' => 'Post Deleted Failed',
            ];
        }
    }
}
