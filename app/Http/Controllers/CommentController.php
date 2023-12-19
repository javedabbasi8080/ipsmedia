<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $comment = Comment::create([
                'body' => $request->user_id->body,
                'user_id' => $request->user_id
            ]);

            CommentWritten::dispatch($comment);

            return response()->json([
                'status' => true,
                'data' => $comment,
                'message' => 'Added successfully',
            ]);
        } catch (\Throwable $th) {

            return  $th;

            return response()->json([
                'status' => false,
                'data'   => null,
                'message' => 'An error occurred while processing the request.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
