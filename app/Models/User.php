<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'badge',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }


    /**
     * The badges that a user has achieved.
     */
    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges', 'user_id', 'badge_id');
    }

    /**
     * The  achievements  that a user has unlocked.
     */
    public function unlocked_achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements', 'user_id', 'achievement_id')
            ->withTimestamps();
    }

    public function nextBadge()
    {
        $unlockedAchievementsCount = $this->unlocked_achievements()->count();

        if ($unlockedAchievementsCount >= 10) {
            return 'Master';
        } elseif ($unlockedAchievementsCount >= 8) {
            return 'Master';
        } elseif ($unlockedAchievementsCount >= 4) {
            return 'Advanced';
        } elseif ($unlockedAchievementsCount >= 1) {
            return 'Intermediate';
        } else {
            return 'Beginner';
        }
    }

    public function remaingUnlockNextBadge()
    {
        $totalBadges = Badge::count();
        $unlockedBadgesCount = $this->badges()->groupBy('user_id')->count();
        $remaining =  $totalBadges - $unlockedBadgesCount;
        return $remaining;
    }

    public function nextAvailableAchievements()
    {
        $unlockedAchievements = $this->unlocked_achievements()->pluck('name')->toArray();
        $allAchievements = Achievement::get()->pluck('name')->toArray();
        $nextAvailableAchievements = array_values(array_diff($allAchievements, $unlockedAchievements));
        return $nextAvailableAchievements;
    }
}
