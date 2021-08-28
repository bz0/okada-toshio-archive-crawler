<?php
    require_once dirname(__FILE__) . '/vendor/autoload.php';

    use OkadaToshioArchiveCrawler\Crawler\Request;
    use OkadaToshioArchiveCrawler\Crawler\Login;
    use OkadaToshioArchiveCrawler\Crawler\Niconama\ArticleIndex;
    use OkadaToshioArchiveCrawler\Crawler\Niconama\Section;
    use OkadaToshioArchiveCrawler\Domain\Models;
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    /*
    //ニコ生テキスト
    $checkedCategories = [2012,2013,2014,2015,2016,2017,2018,2019,2020,2021];
    $params = [
        "both" => "false",
        "orderBy" => 1,
    ];

    $articles = [];
    foreach($checkedCategories as $year){
        $params["checkedCategories"] = $year;
        $client   = new Request(new GuzzleHttp\Client());
        $results  = $client->execute(new ArticleIndex(new Models\ArticleIndex()), $params)->scraper();
        $articles = array_merge($articles, $results);
    }
    */

    //ログイン
    $params = [
        "email" => $_ENV["EMAIL"],
        "password" => $_ENV["PASSWORD"]
    ];

    $req = new Request();
    $login  = $req->execute(new Login(), $params)->getClient();

    $req = new Request($login);
    $req->execute(new Section(new Models\Section()), ['slug'=>'20210815-nicotext'])->scraper();