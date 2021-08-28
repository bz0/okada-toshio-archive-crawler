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

        public function request($client, $slug): \OkadaToshioArchiveCrawler\Crawler\Niconama\Section
        {
            $this->url  = $this->generate_url($slug);
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