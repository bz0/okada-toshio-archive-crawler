<?php
namespace OkadaToshioArchiveCrawler\Domain\Entities;

class Article {
    private $title;
    private $slug;
    private $body_text;
    private $body_html;

    public function setVariables($params)
    {
        foreach(array_keys(get_object_vars($this)) as $name)
        {
            if (isset($params[$name])){
                $this->$name = $params[$name];
            }
        }
    }

    public function getVariables(): array
    {   
        return get_object_vars($this);
    }
    
    /**
     * @param string $html
     */
    public function set_body_text(string $html){
        $this->body_text = strip_tags($html);
    }

    /**
     * @param string $html
     */
    public function set_body_html(string $html){
        $this->body_html = $html;
    }
}