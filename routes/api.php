<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('pockets', 'PocketsController@getPockets')->name('get-pockets');
Route::post('pocket-create', 'PocketsController@createPocket')->name('create-pocket');

Route::get('contents/{pocket_id}', 'ContentsController@getContents');
Route::post('content-create', 'ContentsController@createContent')->name('content-create');
Route::get('content-search', 'ContentsController@getContentByHashTag')->name('content-search');
Route::get('content-delete/{content_id}', 'ContentsController@deleteContent')->name('content-delete');



//
//Route::get('test', function (){
//
//    $url = "https://onextrapixel.com/25-trendy-websites-with-header-images/";
//    $title = filter_var($url, FILTER_VALIDATE_URL);
//
////    $client = new \Goutte\Client(Symfony\Component\HttpClient\HttpClient::create(['verify_peer' => false, 'verify_host' => false]));
//////    $crawler = $client->request('GET', 'https://www.symfony.com/blog/');
//////    return $crawler->filter('h1')->first()->text();
//////    $crawler->filter('.single-page-content')->text();
////
////    $title = [];
//////    $crawler = $client->request('GET', 'https://example.com/');
//////    $crawler = $client->request('GET', 'https://symfony.com/doc/current/components/dom_crawler.html');
////    $crawler = $client->request('GET', 'https://onextrapixel.com/25-trendy-websites-with-header-images/');
////
////    if ($crawler->filter('h1')->count() > 0 ){
////        $title['title'] = trim($crawler->filter('h1')->text());
////    }
////    else if ($crawler->filter('h2')->count() > 0 ){
////        $title['title'] = trim($crawler->filter('h2')->text());
////    }
////    else if($crawler->filter('title')->count() > 0  ) {
////        $title['title'] = trim($crawler->filter('title')->text());
////    }
////    else {
////        $title['title'] = "title not found";
////    }
////
////    $title['excerpt'] = $crawler->filter('p')->each(function (\Symfony\Component\DomCrawler\Crawler $node) {
////        return $node->text();
////    });
////    $title['excerpt'] = substr(strip_tags(trim(implode(" ",$title['excerpt']))),0, 1000);
////
//////    $title['url'] = trim(pathinfo($crawler->getUri(), PATHINFO_DIRNAME));// $crawler->filter('article')->text();
//////    $title['excerpt1'] = substr(strip_tags(trim($crawler->filter('article')->text())), 0, 1000);
//////    $title['image0'] = $crawler->filter('img')->count();//->first()->image()->getUri();
//////    $title['image'] = $crawler->filter('header > img')->each(function ($node) {
//////    $title['image'] = $crawler->filter('img')->each(function ($node) {
//////        return $node->image()->getUri().'<br>';
//////    });
////
//
//    return response()->json($title);
//});
