<?php
namespace OkadaToshioArchiveCrawler\Domain\Models;

class ArticleIndex {
    private $id;
    private $title;
    private $slug;

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