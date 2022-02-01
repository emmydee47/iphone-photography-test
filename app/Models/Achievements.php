<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    const LESSONS_WATCHED_ACHIEVEMENTS = [
        "1" => "First Lesson Watched",
        "5" => "5 Lessons Watched",
        "10" => "10 Lessons Watched",
        "25" => "25 Lessons Watched",
        "50" => "50 Lessons Watched",
    ];

    const COMMENTS_WRITTEN_ACHIEVEMENTS = [
        "1" => "First Comment Written",
        "3" => "3 Comments Written",
        "5" => "5 Comments Written",
        "10" => "10 Comment Written",
        "20" => "20 Comment Written",
    ];
}
