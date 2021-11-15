<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ContentScraperEvent
{
    use SerializesModels;

    public $content;

    public function __construct($content)
    {
        $this->content = $content;
        Log::info("event fired for scraping.");
    }
}
