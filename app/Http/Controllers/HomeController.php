<?php

namespace App\Http\Controllers;

use App\Models\NewsLists;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    public function crawlData()
    {
        $url = 'https://vnexpress.net/thoi-su/chinh-tri';
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $link = $crawler->filter('.description > a')->each(
            function (Crawler $node) {
                return $node->attr('href');
            }
        );
        for ($i = 0; $i < count($link); $i++) {
            $valid = NewsLists::where('link', $link[$i])->first();
            if ($valid == null) {
                $link_crawler = $client->request('GET', $link[$i]);
                $link_crawler->each(
                    function (Crawler $node) {
                        $link = $node->filter('.social_twit')->attr('data-url');
                        $title =  $node->filter('.title-detail')->text();
                        try {
                            $image =  $node->filter('.fig-picture > picture > img')->attr('data-src');
                        } catch (\Throwable $th) {
                            $image = 'https://s1.vnecdn.net/vnexpress/restruct/i/v738/v2_2019/pc/graphics/no-thumb-5x3.jpg';
                        }
                        $short_description =  $node->filter('.description')->text();
                        // $description =  $node->filter('.fck_detail ')->html();
                        $description =  $node->filter('.fck_detail ')->text();
                        // dd($description);
                        $date =  $node->filter('.date')->text();
                        NewsLists::create(["link" => $link, "title" => $title, "image" => $image, "short_description" => $short_description, "description" => $description, "date" => $date]);
                    }
                );
            }
        }
        $result = NewsLists::get();
        return response()->json($result);
    }

    public function getResult()
    {
        $result = NewsLists::paginate(5);
        return response()->json($result);
    }
}
