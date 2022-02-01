<?php

namespace App\Providers;

use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\UnlockBadge;
use App\Listeners\UnlockCommentAchievement;
use App\Listeners\UnlockLessonAchievement;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            UnlockCommentAchievement::class,
            UnlockBadge::class,
        ],
        LessonWatched::class => [
            UnlockLessonAchievement::class,
            UnlockBadge::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
