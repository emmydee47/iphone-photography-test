<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\LessonWatched;
use App\Listeners\UnlockLessonAchievement;
use App\Models\User;
use App\Models\Lesson;

class UnlockLessonAchievementListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unlock_Lesson_achievement()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $event = new LessonWatched($lesson, $user);
        $listener = new UnlockLessonAchievement();
        $achievement = $listener->handle($event);
        $this->assertArrayHasKey('achievement_name', $achievement);
        $this->assertArrayHasKey('user', $achievement);
        $this->assertIsObject($achievement['user']);
        $this->assertIsString($achievement['achievement_name']);
       

    }
}
