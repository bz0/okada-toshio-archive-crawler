<?php
    namespace OkadaToshioArchiveCrawler\Crawler;
    
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;
    use OkadaToshioArchiveCrawler\Domain\Models;

    class Login implements PageInterface{
        const PATH = "login";

        private $client;
        private $url;

        public function generate_url(): string
        {
            return 'https://' . SiteConfig::DOMAIN . '/' . self::PATH;
        }


        public function request($client, array $params): PageInterface
        {
            $this->url  = $this->generate_url();

            //ログイン画面に入りtokenを取得
            $this->client = $client;
            $response = $this->client->request("GET", $this->url);
            $token = $response->filter('input[name=_token]')->attr('value');
            $params['_token'] = $token;

            //ログインする
            $this->client->request("POST", $this->url, $params);

            return $this;
        }

        public function scraper(): array
        {
            return [];
        }

        public function getClient()
        {
            return $this->client;
        }
    }