<?php
    require_once dirname(__FILE__) . '/vendor/autoload.php';
    require_once dirname(__FILE__) . '/bootstrap.php';

    use OkadaToshioArchiveCrawler\Crawler\Request;
    use OkadaToshioArchiveCrawler\Crawler\Login;
    use OkadaToshioArchiveCrawler\Crawler\Niconama;
    use OkadaToshioArchiveCrawler\Domain\Entities;
    use OkadaToshioArchiveCrawler\Repository\ArticleRepository;
    use OkadaToshioArchiveCrawler\Repository\SectionRepository;

    //------------------------------------------
    //ニコ生テキスト記事一覧取得
    //------------------------------------------
    $checkedCategories = [2012,2013,2014,2015,2016,2017,2018,2019,2020,2021];
    $params = [
        "both" => "false",
        "orderBy" => 1,
    ];

    $articles = new Entities\Articles();
    foreach($checkedCategories as $year){
        $params["checkedCategories"] = $year;
        $client   = new Request(new GuzzleHttp\Client());
        $results  = $client->execute(new Niconama\Article(new Entities\Article()), $params)->scraper();
        
        foreach($results as $row){
            $articles->add($row);
        }
    }

    //------------------------------------------
    //ログイン
    //------------------------------------------
    $params = [
        "email" => $_ENV["EMAIL"],
        "password" => $_ENV["PASSWORD"]
    ];

    $req = new Request();
    $login  = $req->execute(new Login(), $params)->getClient();

    //------------------------------------------
    //ニコ生テキスト記事取得（セクション単位）
    //------------------------------------------
    $sections = new Entities\Sections();
    foreach($articles->getIterator() as $article){
        $req = new Request($login);
        $results = $req->execute(new Niconama\Section(new Entities\Section(), $article), ['slug' => $article->slug])->scraper();
        foreach($results as $row){
            $sections->add($row);
        }
    }

    


