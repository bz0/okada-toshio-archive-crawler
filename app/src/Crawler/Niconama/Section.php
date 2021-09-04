<?php
    namespace OkadaToshioArchiveCrawler\Crawler\Niconama;
    
    use OkadaToshioArchiveCrawler\Crawler\SiteConfig;
    use OkadaToshioArchiveCrawler\Crawler\PageInterface;
    use OkadaToshioArchiveCrawler\Domain\Entities;

    class Section implements PageInterface{
        const PATH = "contents/detail/";
        const METHOD = "GET";
        const MATCH_MOVIE_TIME = "/動画【(\d+:\d+:\d+)】/";

        private $response;
        private $url;
        private $section;
        private $sections;
        private $article;
        private $slug;

        public function __construct(Entities\Sections $sections, Entities\Section $section, Entities\Article $article)
        {
            $this->sections = $sections;
            $this->section = $section;
            $this->article = $article;
        }

        public function generate_url($slug): string
        {
            return 'https://' . SiteConfig::DOMAIN . '/' . self::PATH . $slug;
        }

        public function request($client, array $params): \OkadaToshioArchiveCrawler\Crawler\Niconama\Section
        {
            $this->slug = $params['slug'];
            $this->url  = $this->generate_url($params['slug']);
            $this->response = $client->request(self::METHOD, $this->url);

            return $this;
        }

        public function scraper(): PageInterface
        {
            if (!$this->response)
            {
                return false;
            }

            $section_title_list = $section_body_html_list = $movie_time_list = [];
            $section_id = -1;

            $this->response->filter('.nicotext')->children()->each(function($node) use (&$movie_time_list, &$section_title_list, &$section_body_html_list, &$section_id) {
                $is_accept_html = true;

                if ($node->nodeName() == "ul" && $node->filter('li')->count() > 1){ //目次
                    return;
                }

                if ($node->nodeName() == "h2"){
                    $movie_time_list[] = $node->text();
                    return;
                }

                if ($node->nodeName() == "ul" && $node->filter('li')->count() == 1){ //動画時間
                    preg_match(self::MATCH_MOVIE_TIME, $node->filter('li a')->text(), $match);
                    if (isset($match[1])){
                        $section_title_list[] = $match[1];
                    }
                    
                    $section_id++;
                    return;
                }

                if ($is_accept_html){
                    $section_body_html_list[$section_id] .= $node->html(); //html
                }
            });

            if (count($section_title_list) === count($movie_time_list) && 
                count($section_title_list) === count($section_body_html_list) &&
                count($section_body_html_list) === count($movie_time_list)){
                $this->setValues($section_title_list, $movie_time_list, $section_body_html_list);
            }else{
                throw new \Exception("目次のセクションと動画時間・本文の数が合っていません");
            }

            $this->article->set_body_html($this->response->filter('.nicotext')->html());
            $this->article->set_body_text($this->response->filter('.nicotext')->html());

            return $this;
        }

        private function setValues(array $section_title_list, array $movie_time_list, array $section_body_html_list): array
        {
            $results = [];
            foreach($section_title_list as $i => $section_title){
                $this->section->setVariables([
                    'slug' => $this->slug,
                    'section_id' => $i,
                    'section_title' => $section_title,
                    'section_body_text' => isset($section_body_html_list[$i]) ? strip_tags($section_body_html_list[$i]) : '',
                    'section_body_html' => isset($section_body_html_list[$i]) ? $section_body_html_list[$i] : '',
                    'movie_time' => isset($movie_time_list[$i]) ? $movie_time_list[$i] : ''
                ]);
                $this->sections->add(clone $this->section);
            }

            return $results;
        }

        public function get_sections()
        {
            return $this->sections;
        }

        public function get_article()
        {
            return $this->article;
        }
    }