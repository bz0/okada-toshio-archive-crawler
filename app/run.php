<?php
    require_once dirname(__FILE__) . '/vendor/autoload.php';

    use OkadaToshioArchiveCrawler\Crawler\Request;
    use OkadaToshioArchiveCrawler\Crawler\Login;
    use OkadaToshioArchiveCrawler\Crawler\Niconama;
    use OkadaToshioArchiveCrawler\Domain\Entities;
    use OkadaToshioArchiveCrawler\Repository\ArticleRepository;
    use OkadaToshioArchiveCrawler\Repository\SectionRepository;

    require_once dirname(__FILE__) . '/bootstrap.php';

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
        $article  = $client->execute(new Niconama\Article($articles, new Entities\Article()), $params)->scraper();
        $articles = $article->get_articles();
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
    foreach($articles->getIterator() as $key => $article){
        $req = new Request($login);
        $section = $req->execute(new Niconama\Section($sections, new Entities\Section(), $article), ['slug' => $article->getVariables()['slug']])->scraper();
        $sections = $section->get_sections();

        $article = $section->get_article();
        $articles->set($key, $article);
    }

    var_dump($articles);
    var_dump($sections);


    


