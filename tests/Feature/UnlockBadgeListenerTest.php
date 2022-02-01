<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\UnlockBadge;
use App\Models\Comment;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Badges;
class UnlockBadgeListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unlock_badge()
    {
        $comment = Comment::factory()->create();
        $lesson = Lesson::factory()->create();
        $user = User::factory()->create();
      
        
        $comment_event = new CommentWritten($comment);
        $listener = new UnlockBadge();
        $comment_achievement = $listener->handle($comment_event);

        $this->assertArrayHasKey('badge_name', $comment_achievement);
        $this->assertArrayHasKey('user', $comment_achievement);
        $this->assertIsString($comment_achievement['badge_name']);
        $this->assertIsObject($comment_achievement['user']);

        $lesson_event = new LessonWatched($lesson, $user);
        $listener = new UnlockBadge();
        $lesson_achievement = $listener->handle($lesson_event);

        $this->assertArrayHasKey('badge_name', $lesson_achievement);
        $this->assertArrayHasKey('user', $lesson_achievement);
        $this->assertIsString($lesson_achievement['badge_name']);
        $this->assertIsObject($lesson_achievement['user']);

    }
}
