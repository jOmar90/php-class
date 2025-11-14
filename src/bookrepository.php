<?php

namespace Mjoma\PhpClass;

class BookRepository
{
    private array $books = [];

    public function add(Book ...$books): void
    {
        foreach ($books as $book) {
            $newIsbn = $book->getIsbn();
            foreach ($this->books as $existingBook) {
                if ($existingBook->getIsbn() === $newIsbn) {
                    throw new \InvalidArgumentException("A book with ISBN {$newIsbn} already exists.");
                }
                $this->books[] = $book;
            }
        }
    }

    public function get(int $id): ?Book
    {
        foreach ($this->books as $book) {
            if ($book->getId() === $id) {
                return $book;
            }
        }
        return null;
    }

    public function getAll(): array
    {
        return $this->books;
    }

    public function remove(int $id): void
    {
        foreach ($this->books as $index => $book) {
            if ($book->getId() === $id) {
                unset($this->books[$index]);
                // Reindex the array to maintain consistent indices
                $this->books = array_values($this->books);
                return;
            }
        }
    }

    public function getBookByAuthor(int $authorId): array
    {
        $booksByAuthor = [];
        foreach ($this->books as $book) {
            if ($book->getAuthor()->getId() === $authorId) {
                $booksByAuthor[] = $book;
            }
        }
        return $booksByAuthor;
    }
}
