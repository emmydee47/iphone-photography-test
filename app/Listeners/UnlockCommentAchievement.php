<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Models\Achievements;

class UnlockCommentAchievement
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $comment = $event->comment;
        $user = $comment->user;
        $comments_achievements = Achievements::COMMENTS_WRITTEN_ACHIEVEMENTS;

        $comments = count($user->comments);
        $unlocked_achievement = "";
        array_walk($comments_achievements, function($value, $key) use(&$unlocked_achievement, $comments){
            if( $comments == (int)$key){
                $unlocked_achievement = $value;
            }
        });
        return ["achievement_name"=>$unlocked_achievement, "user"=>$user];
    }
}
