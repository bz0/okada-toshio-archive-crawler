<?php
    namespace OkadaToshioArchiveCrawler\Repository;
    use OkadaToshioArchiveCrawler\Domain\Entities\Article;

    class ArticleRepository
    {
        protected $table = 'articles';
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function insert(Article $article)
        {
            return $this->db::table($this->table)->insert($article->getVariables());
        }
    
        public function getAll()
        {
            return $this->db::table($this->table)->get();
        }
    }