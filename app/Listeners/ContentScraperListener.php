<?php

namespace App\Listeners;

use App\Events\ContentScraperEvent;
use App\Jobs\ContentScraperJobs;
use Illuminate\Support\Facades\Log;

class ContentScraperListener
{
    public function handle(ContentScraperEvent $event)
    {
        Log::info("listener started for scraping.");
       dispatch(new ContentScraperJobs($event->content));
    }
}
