<?php

namespace App\Services;

use App\Events\{AchievementUnlocked, BadgeUnlocked};
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;

class AchievementService
{
    public function unlockLessonAchievements(User $user, $lessonsWatched)
    {
        if ($lessonsWatched === 1) {
            $this->unlockAchievement('First Lesson Watched', $user);
        } elseif ($lessonsWatched === 5) {
            $this->unlockAchievement('5 Lessons Watched', $user);
        } elseif ($lessonsWatched === 10) {
            $this->unlockAchievement('10 Lessons Watched', $user);
        } elseif ($lessonsWatched === 25) {
            $this->unlockAchievement('25 Lessons Watched', $user);
        } elseif ($lessonsWatched === 50) {
            $this->unlockAchievement('50 Lessons Watched', $user);
        }
    }

    public function unlockCommentAchievements(User $user, $commentsWritten)
    {
        if ($commentsWritten === 1) {
            $this->unlockAchievement('First Comment Written', $user);
        } elseif ($commentsWritten === 3) {
            $this->unlockAchievement('3 Comments Written', $user);
        } elseif ($commentsWritten === 5) {
            $this->unlockAchievement('5 Comments Written', $user);
        } elseif ($commentsWritten === 10) {
            $this->unlockAchievement('10 Comments Written', $user);
        } elseif ($commentsWritten === 20) {
            $this->unlockAchievement('20 Comments Written', $user);
        }
    }

    public function checkBadgeUnlock(User $user)
    {
        $unlockedAchievements = $user->unlocked_achievements()->count();

        if ($unlockedAchievements >= 10) {
            $this->unlockBadge('Master', $user);
        } elseif ($unlockedAchievements >= 8) {
            $this->unlockBadge('Advanced', $user);
        } elseif ($unlockedAchievements >= 4) {
            $this->unlockBadge('Intermediate', $user);
        } elseif ($unlockedAchievements >= 0) {
            $this->unlockBadge('Beginner', $user);
        }
    }

    protected function unlockAchievement($achievementName, User $user)
    {
        $achievement = Achievement::where('name', $achievementName)->first();
        // Logic to unlock an achievement for a user
        $user->unlocked_achievements()->attach($achievement->id);

        // Fire AchievementUnlocked event
        event(new AchievementUnlocked($achievementName, $user));
    }

    protected function unlockBadge($badgeName, User $user)
    {
        // Logic to unlock a badge for a user
        $badge = Badge::where('name',$badgeName)->first();
        $user->update(['badge' => $badgeName]);
        $user->badges()->attach($badge->id);
     
        // Fire BadgeUnlocked event
        event(new BadgeUnlocked($badgeName, $user));
    }
}
