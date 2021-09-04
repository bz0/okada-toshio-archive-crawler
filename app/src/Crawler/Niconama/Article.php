<?php
    namespace OkadaToshioArchiveCrawler\Crawler\Niconama;
    
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;
    use OkadaToshioArchiveCrawler\Domain\Entities;

    class Article implements PageInterface{
        const PATH = "api/nicotext";
        const METHOD = "GET";

        private $response;
        private $url;
        private $article;
        private $articles;

        public function __construct(Entities\Articles $articles, Entities\Article $article)
        {
            $this->articles = $articles;
            $this->article = $article;
        }

        public function generate_url($params): string
        {
            return 'https://' . SiteConfig::DOMAIN . '/' . self::PATH . '?' . http_build_query($params);
        }

        public function request($client, array $params): \OkadaToshioArchiveCrawler\Crawler\Niconama\Article
        {
            $this->url  = $this->generate_url($params);
            $this->response = $client->request(self::METHOD, $this->url);

            return $this;
        }

        public function scraper(): PageInterface
        {
            if (!$this->response)
            {
                return false;
            }

            $json = json_decode($this->response->getBody()->getContents(), true);

            if (!isset($json[0]['records']))
            {
                return false;
            }

            foreach($json[0]['records'] as $row) {
                $this->article->setVariables($row);
                $this->articles->add(clone $this->article);
            }

            return $this;
        }

        /**
         * @return Entities\Articles
         */
        public function get_articles(): Entities\Articles
        {
            return $this->articles;
        }
    }