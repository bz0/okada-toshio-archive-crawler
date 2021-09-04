<?php
    namespace OkadaToshioArchiveCrawler\Repository;
    use OkadaToshioArchiveCrawler\Domain\Entities\Section;

    class SectionRepository
    {
        protected $table = 'sections';
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        public function insert(Section $section)
        {
            return $this->db::table($this->table)->insert($section->getVariables());
        }
    
        public function getAll()
        {
            return $this->db::table($this->table)->get();
        }
    }