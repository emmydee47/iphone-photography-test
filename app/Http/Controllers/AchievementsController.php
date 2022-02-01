<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Badges;
use App\Models\Achievements;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    
    public function index(User $user){
        $watched = count($user->watched()->get());
        $comments = count($user->comments);
        $lessons_achievements =  Achievements::LESSONS_WATCHED_ACHIEVEMENTS;
        $comments_achievements = Achievements::COMMENTS_WRITTEN_ACHIEVEMENTS;  
        $total_achievements = $this->getTotalAchievements($watched, $comments, $lessons_achievements, $comments_achievements);
        $badges = Badges::BADGES;

        return response()->json([
            'unlocked_achievements' => $this->getUnlockedAchievements($watched, $comments, $lessons_achievements, $comments_achievements ),
            'next_available_achievements' => $this->getNextAvailableAchievements($watched, $comments, $lessons_achievements, $comments_achievements ),
            'current_badge' =>  $this->getCurrentBadge($total_achievements, $badges),
            'next_badge' => $this->getNextBadge($total_achievements, $badges),
            'remaing_to_unlock_next_badge' => $this->getBadgeBalance($total_achievements, $badges)
        ]);
    }

    private function getUnlockedAchievements($watched, $comments, $lessons_achievements, $comments_achievements ){
        $unlocked_achievements = [];
        array_walk($lessons_achievements, function($key, $value) use(&$unlocked_achievements, $watched){
            if( $watched < (int)$key){
                $unlocked_achievements[] = $value;
            }});
        array_walk($comments_achievements , function($key, $value) use(&$unlocked_achievements, $comments){
            if($comments < (int)$key){
                $unlocked_achievements[] = $value;
            }});
        return $unlocked_achievements;
    }

    private function getNextAvailableAchievements($watched, $comments, $lessons_achievements, $comments_achievements ){
        $next_available_achievements = [];
        $next_lessons_watched_achievement = "";
        $next_comments_written_achievement = "";
        array_walk($lessons_achievements, function($key, $value) use(&$next_lessons_watched_achievement, $watched){
            if( $watched < (int)$key){
                $next_lessons_watched_achievement = $value;
                return;
            }});
        $next_available_achievements[] = $next_lessons_watched_achievement;

        array_walk($comments_achievements , function($key, $value) use(&$next_comments_written_achievement,$comments){
            if($comments < (int)$key){
                $next_comments_written_achievement = $value;
                return;
            }});
        $next_available_achievements[] = $next_comments_written_achievement;
        return $next_available_achievements;

    }

    private function getCurrentBadge($total_achievements, $badges){
        $current_badge = "";
        array_walk($badges, function($key, $value) use(&$current_badge, $total_achievements){
            if( $total_achievements >= (int)$key){
                $current_badge = $value;
            }
        });

        return $current_badge;
    }

    private function getNextBadge($total_achievements, $badges){
        $next_badge = "";
        array_walk($badges, function($key, $value) use(&$next_badge, $total_achievements){
            if( $total_achievements < (int)$key){
                $next_badge = $value;
                return;
            }
        });
        return $next_badge;

    }

    private function getBadgeBalance($total_achievements, $badges){
        $number_of_achievements = 0;
        array_walk($badges, function($key, $value) use(&$number_of_achievements, $total_achievements){
            if( $total_achievements < (int)$key){
                $number_of_achievements = $key - $total_achievements;
                return;
            }
        });
        return $number_of_achievements;
    }

    public function getTotalAchievements($watched, $comments, $lessons_achievements, $comments_achievements){
        $total_achievements = 0;      
        array_walk($lessons_achievements, function(&$value, $key) use(&$total_achievements, $watched){
            if( $watched >= (int)$key){
                $total_achievements++;
            }});

        array_walk($comments_achievements, function(&$value, $key) use(&$total_achievements, $comments){
            if($comments >= (int)$key){
                $total_achievements++;
            }});
        return $total_achievements;
    }

   
}
