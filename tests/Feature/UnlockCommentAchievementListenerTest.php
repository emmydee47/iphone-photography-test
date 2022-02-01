<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Events\CommentWritten;
use App\Listeners\UnlockCommentAchievement;
use App\Models\Comment;


class UnlockCommentAchievementListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unlock_comment_achievement()
    {
        $comment = Comment::factory()->create();
        $event = new CommentWritten($comment);
        $listener = new UnlockCommentAchievement();
        $achievement = $listener->handle($event);
        $this->assertArrayHasKey('achievement_name', $achievement);
        $this->assertArrayHasKey('user', $achievement);
        $this->assertIsString($achievement['achievement_name']);
        $this->assertIsObject($achievement['user']);

    }
}
