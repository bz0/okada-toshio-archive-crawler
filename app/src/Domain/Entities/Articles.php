<?php
namespace OkadaToshioArchiveCrawler\Domain\Entities;

class Articles implements \IteratorAggregate
{
    private $articles;

    public function __construct()
    {
        $this->articles = new \ArrayObject();
    }

    public function add(Article $article)
    {
        $this->articles[] = $article;
    }

    public function getIterator(): \ArrayIterator
    {
        return $this->articles->getIterator();
    }

    public function set($key, Article $article)
    {
        $this->articles[$key] = $article;
    }
}