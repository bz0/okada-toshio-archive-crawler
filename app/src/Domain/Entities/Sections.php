<?php
namespace OkadaToshioArchiveCrawler\Domain\Entities;

class Sections implements \IteratorAggregate
{
    private $sections;

    public function __construct()
    {
        $this->articles = new \ArrayObject();
    }

    public function add(Section $section)
    {
        $this->sections[] = $section;
    }

    public function getIterator(): \ArrayIterator
    {
        return $this->sections->getIterator();
    }
}