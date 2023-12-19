<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Services\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;

class LessonWatchedListener implements ShouldQueue
{
    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    public function handle(LessonWatched $event)
    {
        $user = $event->user; // Assuming the event provides the user
        $lessonsWatched = $user->watched()->count(); // Assuming 'watched' is the relationship to lessons
        
        print_r($user);
        // Unlock lesson-related achievements and check badge unlocking
        $this->achievementService->unlockLessonAchievements($user, $lessonsWatched);
        $this->achievementService->checkBadgeUnlock($user);
    }
}

