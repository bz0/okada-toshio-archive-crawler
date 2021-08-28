<?php
namespace OkadaToshioArchiveCrawler\Domain\Models;

class Article {
    private $id;
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
}