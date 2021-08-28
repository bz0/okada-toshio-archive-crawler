<?php
    namespace OkadaToshioArchiveCrawler\Crawler;
    
    interface PageInterface {
        public function request($client, array $params);
        public function scraper(): array;
    }