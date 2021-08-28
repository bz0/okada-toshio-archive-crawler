<?php
    namespace OkadaToshioArchiveCrawler\Crawler\Niconama;
    
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;
    use OkadaToshioArchiveCrawler\Domain\Models;

    class ArticleIndex implements PageInterface{
        const PATH = "api/nicotext";
        const METHOD = "GET";

        private $response;
        private $url;
        private $model;

        public function __construct(Models\ArticleIndex $model)
        {
            $this->model = $model;
        }

        public function generate_url($params): string
        {
            return 'https://' . SiteConfig::DOMAIN . '/' . self::PATH . '?' . http_build_query($params);
        }

        public function request($client, array $params): \OkadaToshioArchiveCrawler\Crawler\Niconama\ArticleIndex
        {
            $this->url  = $this->generate_url($params);
            $this->response = $client->request(self::METHOD, $this->url);

            return $this;
        }

        public function scraper(): array
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

            $results = [];
            foreach($json[0]['records'] as $row) {
                $this->model->setVariables($row);
                $results[] = clone $this->model;
            }

            return $results; 
        }
    }