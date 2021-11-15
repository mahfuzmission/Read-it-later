<?php

namespace App\Jobs;

use App\Models\Content;
use Goutte\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpClient\HttpClient;


class ContentScraperJobs implements ShouldQueue
{
    private $content;

    public function __construct ($content) {
        $this->content = $content;
    }

    public function handle (){
        $url = $this->content->content;

        try {
            Log::info("job started for scraping.");

            if(filter_var($url, FILTER_VALIDATE_URL)) {
                $client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
                $crawler = $client->request('GET', $url);

                $content = Content::find($this->content->id);
                $content->url = $url;
                $content->title = $this->fetchTitle($crawler);
                $content->excerpt = $this->fetchExcerpt($crawler);
                $content->image = $this->fetchHeaderImage($crawler);;
                $content->save();
            }
        }catch (\Exception $exception)
        {
            Log::info("exception generated for url : ".$url);
            Log::info("exception for url : ".json_encode($exception->getMessage()));
        }
    }

    public function fire($job)
    {
        if ($job->attempts() >= 3)
        {
            $job->delete();
        }
    }


    private function fetchTitle($crawler)
    {
        if ($crawler->filter('h1')->count() > 0 ){
            $title = trim($crawler->filter('h1')->text());
        }
        else if ($crawler->filter('h2')->count() > 0 ){
            $title = trim($crawler->filter('h2')->text());
        }
        else if($crawler->filter('title')->count() > 0  ) {
            $title = trim($crawler->filter('title')->text());
        }
        else {
            $title = "title not found";
        }

        return $title;
    }

    private function fetchExcerpt($crawler)
    {
        $excerpt = $crawler->filter('p')->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
            return $node->text();
        });
        $excerpt = substr(strip_tags(trim(implode(" ",$excerpt))),0, 1000);

        if(empty($excerpt)) {
            $excerpt = null;
        }

        return $excerpt;
    }

    private function fetchHeaderImage($crawler)
    {
        return ($crawler->filter('header > img')->count() > 0) ? $crawler->filter('img')->first()->image()->getUri() : null;
    }
}
