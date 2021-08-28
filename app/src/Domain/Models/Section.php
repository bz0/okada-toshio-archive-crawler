<?php
namespace OkadaToshioArchiveCrawler\Domain\Models;

class Section {
    private $slug;
    private $section_id;
    private $section_title;
    private $section_body_text;
    private $section_body_html;

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