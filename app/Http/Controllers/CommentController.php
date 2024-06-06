<?php

// app/Http/Controllers/CommentController.php

// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'media_id' => 'required|exists:media,id',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'media_id' => $request->media_id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully.');
    }

    public function update(Request $request, Comment $comment)
    {
        if (Auth::user()->role == 'admin' || Auth::id() == $comment->user_id) {
            $request->validate(['content' => 'required']);
            $comment->update(['content' => $request->content]);
            return redirect()->back()->with('success', 'Comment updated successfully.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }

    public function destroy(Comment $comment)
    {
        if (Auth::user()->role == 'admin' || Auth::id() == $comment->user_id) {
            $comment->delete();
            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        return redirect()->back()->with('error', 'Unauthorized action.');
    }
}

