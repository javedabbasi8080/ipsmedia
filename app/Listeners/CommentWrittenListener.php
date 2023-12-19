<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Services\AchievementService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentWrittenListener implements ShouldQueue
{
    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    public function handle(CommentWritten $event)
    {
        $user = $event->user; // event provides the user
        $commentsWritten = $user->comments()->count();
        
        // Unlock comment-related achievements and check badge unlocking
        $this->achievementService->unlockCommentAchievements($user, $commentsWritten);
        $this->achievementService->checkBadgeUnlock($user);
    }
}
