<?php

namespace Mjoma\PhpClass;

use DateTimeImmutable;

class Book
{
    private int $id;
    private $title;
    private $author;
    private $isbn;
    private $publisher;
    private $publicationDate;
    private $pages;
    public function __construct($id, $title, Author $author, $isbn, $publisher, $publicationDate, $pages)
    {
        if (empty($title)) {
            throw new \InvalidArgumentException("Title cannot be empty.");
        }
        if (!$author instanceof Author) {
            throw new \InvalidArgumentException("Author must be an instance of Author class.");
        }
        if (
            !preg_match('/^(?:\d[\- ]?){9}[\dX]$/i', $isbn) ||    // ISBN-10
            !preg_match('/^(?:\d[\- ]?){13}$/', $isbn)           // ISBN-13
        ) {
            throw new \InvalidArgumentException("Invalid ISBN format.");
        }
        $this->isbn = $isbn;
        if (empty($publisher)) {
            throw new \InvalidArgumentException("Publisher cannot be empty.");
        }
        if (!($publicationDate instanceof DateTimeImmutable) || $publicationDate > new DateTimeImmutable()) {
            throw new \InvalidArgumentException("Publication date must be a DateTimeImmutable object.");
        }
        if (!is_int($pages) || $pages <= 0) {
            throw new \InvalidArgumentException("Pages must be a positive integer.");
        }

        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->isbn = $isbn;
        $this->publisher = $publisher;
        $this->publicationDate = $publicationDate;
        $this->pages = $pages;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getAuthor(): Author
    {
        return $this->author;
    }
    public function getIsbn()
    {
        return $this->isbn;
    }
    public function getPublisher()
    {
        return $this->publisher;
    }
    public function getPublicationDate(): DateTimeImmutable
    {
        return $this->publicationDate;
    }
    public function getPublicationDateAsString(): string
    {
        return $this->publicationDate->format('Y-m-d');
    }
    public function getPages()
    {
        return $this->pages;
    }
}
