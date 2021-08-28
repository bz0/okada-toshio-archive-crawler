<?php
    namespace OkadaToshioArchiveCrawler\Crawler;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;

    class Client
    {
        private $client;

        public function __construct($client=null)
        {
            if (!$client)
            {
                $client = new \Goutte\Client();
            }

            $this->client = $client;
        }

        public function execute(PageInterface $page, array $params)
        {
            return $page->request($this->client, $params);
        }
    }