<?php

namespace App\Http\Controllers;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AchievementService;

class AchievementsController extends Controller
{

    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    public function index(User $user)
    {

        // $unlockedAchievements = $user->unlocked_achievements()->pluck('name')->toArray();
        // $nextAvailableAchievements = $user->nextAvailableAchievements();
        // $currentBadge = $user->badge;
        // $nextBadge = $user->nextBadge();
        // $remainingToUnlockNextBadge = $user->remainingToUnlockNextBadge();


        return response()->json([
            'unlocked_achievements' => [],
            'next_available_achievements' => [],
            'current_badge' => '',
            'next_badge' => '',
            'remaing_to_unlock_next_badge' => 0
        ]);
    }

    public function saveAchievements($lessonId)
    {
        // Lesson::find($id);
        $user = User::find(1);

        $lesson = Lesson::find($lessonId);

        $user->watched()->attach($lessonId,['watched'=>true]);
        // new LessonWatchedListener()->handle($user);
        

        if ($lesson && $user) {
            // Dispatch the LessonWatched event
            // Event::dispatch(new LessonWatched($lesson, $user));
            LessonWatched::dispatch($lesson ,$user);
        }
    }

    public function saveComment()
    {
        $comment = Comment::create([
            'body' => 'body',
            'user_id' => 1
        ]);
        

        // dd($comment);

        CommentWritten::dispatch($comment);

    }

}
