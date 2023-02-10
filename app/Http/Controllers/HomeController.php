<?php

namespace App\Http\Controllers;

use App\Models\NewsLists;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class HomeController extends Controller
{
    //
    public function getResult()
    {
        $url = 'https://vnexpress.net/';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $text = $crawler->each(
            function (Crawler $node) {
                // $node->text();
                $crawl_link  = $node->filter('.title-news > a')->attr('href');
                $link = NewsLists::where('link', $crawl_link)->first();
                dd($crawl_link);
                // if ($link == null) {
                $title  = $node->filter('.title-news')->text();
                $image  = $node->filter('.thumb-art > a > picture > img')->attr('src');
                $short_description  = $node->filter('.description')->text();
                // NewsLists::create(['title' => $title, 'link' => $crawl_link, 'image' => $image, 'short_description' => $short_description]);
                // }
            }
        );
        dd($text);
        
        // $crawler = $client->request('GET', 'https://xoso.mobi/mien-nam/xsag-9-2-2023-ket-qua-xo-so-an-giang-ngay-9-2-2023-p2.html');

        // $crawler->each(
        //     function (Crawler $node) {
        //         $giaidb = $node->filter('.v-gdb')->text();
        //         $giai1  = $node->filter('.v-g1')->text();
        //         $giai2  = $node->filter('.v-g2')->text();
        //         $giai30 = $node->filter('.v-g3-0')->text();
        //         $giai31 = $node->filter('.v-g3-1')->text();
        //         $giai40 = $node->filter('.v-g4-0')->text();
        //         $giai41 = $node->filter('.v-g4-1')->text();
        //         $giai42 = $node->filter('.v-g4-2')->text();
        //         $giai43 = $node->filter('.v-g4-3')->text();
        //         $giai44 = $node->filter('.v-g4-4')->text();
        //         $giai45 = $node->filter('.v-g4-5')->text();
        //         $giai46 = $node->filter('.v-g4-6')->text();
        //         $giai5  = $node->filter('.v-g5')->text();
        //         $giai60 = $node->filter('.v-g6-0')->text();
        //         $giai61 = $node->filter('.v-g6-1')->text();
        //         $giai62 = $node->filter('.v-g6-2')->text();
        //         $giai7  = $node->filter('.v-g7')->text();
        //         $giai8  = $node->filter('.v-g8')->text();

        //         $data = $node->filter('h2.tit-mien')->text();

        //         $list = [
        //             'Tiền Giang',
        //             'Vĩnh Long',
        //             'Đồng Tháp',
        //             'Cà Mau',
        //             'Kiên Giang',
        //             'TP Hồ Chí Minh',
        //             'Bến Tre',
        //             'Vũng Tàu',
        //             'Bạc Liêu',
        //             'Đồng Nai',
        //             'Cần Thơ',
        //             'Sóc Trăng',
        //             'Tây Ninh',
        //             'An Giang',
        //             'Bình Thuận',
        //             'Bình Dương',
        //             'Trà Vinh',
        //             'Long An',
        //             'Bình Phước',
        //             'Hậu Giang',
        //             'Đà Lạt'
        //         ];

        //         foreach ($list as $key => $value) {
        //             // print($value);
        //             if (str_contains($data, $value)) {
        //                 $provinces = $value;
        //             }
        //         }

        //         $list_data = explode(" ", $data);

        //         if ($provinces == 'TP Hồ Chí Minh') {
        //             $date = $list_data[10];
        //             print($date);
        //         } else {
        //             $date = $list_data[8];
        //         }
        //     }
        // );
        $result = NewsLists::get();
        return response()->json($result);
    }
}
