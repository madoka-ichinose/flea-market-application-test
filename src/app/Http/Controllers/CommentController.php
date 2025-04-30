<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->product_id = $product_id;
        $comment->user_id = Auth::id(); 
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('products.show', ['product_id' => $product_id])->with('success', 'コメントを投稿しました');
    }
}
