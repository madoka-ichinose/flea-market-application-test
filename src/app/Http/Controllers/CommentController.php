<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $product_id)
    {
        $comment = new Comment();
        $comment->product_id = $product_id;
        $comment->user_id = Auth::id(); 
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('products.show', ['product_id' => $product_id])->with('success', 'コメントを投稿しました');
    }
}
