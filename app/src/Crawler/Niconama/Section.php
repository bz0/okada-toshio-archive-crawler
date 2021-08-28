<?php
    namespace OkadaToshioArchiveCrawler\Crawler\Niconama;
    
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;
    use OkadaToshioArchiveCrawler\Domain\Models;

    class Section implements PageInterface{
        const PATH = "contents/detail/";
        const METHOD = "GET";

        private $response;
        private $url;
        private $model;

        public function __construct(Models\Section $model)
        {
            $this->model = $model;
        }

        public function generate_url($slug): string
        {
            return 'https://' . SiteConfig::DOMAIN . '/' . self::PATH . $slug;
        }

        public function request($client, array $params): \OkadaToshioArchiveCrawler\Crawler\Niconama\Section
        {
            $this->url  = $this->generate_url($params['slug']);
            $this->response = $client->request(self::METHOD, $this->url);

            return $this;
        }

        public function scraper(): array
        {
            if (!$this->response)
            {
                return false;
            }

            $indexs = [];
            $movies = [];
            $html   = [];
            $section_id = -1;
            $this->response->filter('.nicotext')->children()->each(function($node) use (&$movies, &$indexs, &$section_id, &$html) {
                $is_accept_html = true;

                if ($node->nodeName() == "ul" && $node->filter('li')->count() > 1){ //目次
                    return;
                }

                if ($node->nodeName() == "h2"){
                    $movies[] = $node->text();
                    return;
                }

                if ($node->nodeName() == "ul" && $node->filter('li')->count() == 1){ //動画時間
                    $indexs[] = $node->filter('li a')->text();
                    $section_id++;
                    return;
                }

                if ($is_accept_html){
                    $html[$section_id] .= $node->html();
                }
            });

            var_dump($indexs);
            var_dump($movies);
            var_dump($html);
            exit;

            return $indexs; 
        }
    }