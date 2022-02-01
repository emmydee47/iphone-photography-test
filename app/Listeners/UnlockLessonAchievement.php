<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Models\Achievements;

class UnlockLessonAchievement
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
     * @param  LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        $user = $event->user;
        $watched = count($user->watched()->get());
        $lessons_achievements =  Achievements::LESSONS_WATCHED_ACHIEVEMENTS;
        $unlocked_achievement = "";

        array_walk($lessons_achievements, function($value, $key) use(&$unlocked_achievement, $watched){
            if( $watched >= (int)$key){
                $unlocked_achievement = $value;
            }
        });
        return ["achievement_name"=>$unlocked_achievement, "user"=>$user];
    }
}
