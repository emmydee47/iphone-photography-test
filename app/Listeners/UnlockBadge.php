<?php

namespace App\Listeners;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Http\Controllers\AchievementsController;
use App\Models\Badges;
use App\Models\Achievements;
use App\Models\User;

class UnlockBadge
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $badge = "";
        $user = new User();
        if($event instanceof CommentWritten)
        {
            $comment = $event->comment;
            $user = $comment->user;
           
            $badge = $this->getBadge($user);
        }

        if($event instanceof LessonWatched)
        {
            $user = $event->user;
            $badge = $this->getBadge($user);
        }

        return ["badge_name"=>$badge, "user"=>$user];
    }

    function getBadge($user){
        $comments = count($user->comments);
        $watched = count($user->watched()->get());
        $achievementController = new AchievementsController();
        $lessons_achievements =  Achievements::LESSONS_WATCHED_ACHIEVEMENTS;
        $comments_achievements = Achievements::COMMENTS_WRITTEN_ACHIEVEMENTS;
        $badges = Badges::BADGES;
        $total_achievements = $achievementController->getTotalAchievements($watched,$comments,$lessons_achievements,$comments_achievements);

        $new_badge = "";
        array_walk( $badges, function($value, $key) use(&$new_badge, $total_achievements){
            if( $total_achievements == (int)$key){
                $new_badge=$value;
                
            }
        });
        return  $new_badge;
    }
}
