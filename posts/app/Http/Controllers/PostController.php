<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{

    private $postService;

    public function __construct(PostService $postService)
    {

        $this->postService = $postService;
    }
    public function getAllPosts()
    {
        $response = $this->postService->getAll();

        if ($response['status'] == 200) {
            return $this->successResponse($response['posts'], 'All Post');
        }
        else {
            return $this->errorResponse($response['message'], $response['status']);
        }
    }

    public function store(Request $request)
    {
        $validator = $this->validatePay();

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $response = $this->postService->save($request->all());

        if ($response['status'] == 200) {
            return $this->successResponse($response['post'], $response['message']);
        }
        else {
            return $this->errorResponse($response['message'], $response['status']);
        }
    }

    public function update(Request $request, $postId)
    {
        $validator = $this->validatePay();

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $response = $this->postService->update($postId, $request->all());

        if ($response['status'] == 200) {
            return $this->successResponse($response['post'], $response['message']);
        }
        else {
            return $this->errorResponse($response['message'], $response['status']);
        }
    }

    public function delete($postId)
    {
        $response = $this->postService->delete($postId);

        if ($response['status'] == 200) {
            return $this->successResponse($response['post'], $response['message']);
        }
        else {
            return $this->errorResponse($response['message'], $response['status']);
        }
    }

    public function validatePay()
    {
        return Validator::make(request()->all(), [
            'title' => 'required',
            'post_content' => 'required'
        ]);
    }
}
