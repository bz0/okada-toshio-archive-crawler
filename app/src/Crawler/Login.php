<?php
    namespace OkadaToshioArchiveCrawler;

    class Login {
        private $client;

        public function __construct($client)
        {
            $this->client = $client;
        }

        public function exec()
        {
            
        }

        public function get_client()
        {
            return $this->client;
        }
    }