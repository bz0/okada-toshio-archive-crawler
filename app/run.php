<?php
    require_once dirname(__FILE__) . '/vendor/autoload.php';

    use OkadaToshioArchiveCrawler\Crawler\Client;
    use OkadaToshioArchiveCrawler\Crawler\Niconama\ArticleIndex;
    use OkadaToshioArchiveCrawler\Domain\Models;

    //ニコ生テキスト
    $checkedCategories = [2012,2013,2014,2015,2016,2017,2018,2019,2020,2021];
    $params = [
        "both" => "false",
        "orderBy" => 1,
    ];

    $articles = [];
    foreach($checkedCategories as $year){
        $params["checkedCategories"] = $year;
        $client   = new Client(new GuzzleHttp\Client());
        $results  = $client->execute(new ArticleIndex(new Models\ArticleIndex()), $params);
        $articles = array_merge($articles, $results);
    }

    var_dump($articles);
