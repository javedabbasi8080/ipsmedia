<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class AchievementTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_unlocks_achievements_after_watching_lessons_and_writing_comments()
    {
        $this->withoutMiddleware();
        $user = User::factory()->create();


        $this->post('/lessons-watched', ['lesson_id' => 1, 'user_id' => $user->id]);
        $this->assertCount(1, $user->unlocked_achievements);


        for ($i = 2; $i <= 5; $i++) {
            $this->post('/lessons-watched', ['lesson_id' => 2 + $i, 'user_id' => $user->id]);
        }

        $this->post('/comments', [
            'body' => 'comment 1',
            'user_id' =>  $user->id
        ]);

        for ($i = 2; $i <= 3; $i++) {
            $this->post(
                '/comments',
                [
                    'body' => 'Comment ' . $i,
                    'user_id' =>  $user->id
                ]
            );
        }
    }
}
