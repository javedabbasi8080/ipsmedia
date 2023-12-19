<?php

namespace App\Http\Controllers;

use App\Events\LessonWatched;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return ["wel"];
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
            
            $user = User::find($request->user_id);
            $lesson = Lesson::find($request->lesson_id);
            $user->watched()->attach($request->lesson_id, ['watched' => true]);

            if ($lesson && $user) {
                LessonWatched::dispatch($lesson, $user);
            }

            return response()->json([
                'status' => true,
                'data' => $lesson,
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
