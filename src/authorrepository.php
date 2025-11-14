<?php
namespace Mjoma\PhpClass;
echo "AuthorRepository loaded successfully!";
class AuthorRepository
{
    private $authors = [];
    public function add(Author ...$authors)
    {
        foreach ($authors as $author) {
            $this->authors[] = $author;
        }
    }
    public function get(int $id): ?Author
    {
        foreach ($this->authors as $author) {
            if ($author->getId() === $id) {
                return $author;
            }
        }
        return null;
    }
    public function getAll(): array
    {
        return $this->authors;
    }
    public function remove(int $id): void
    {
        foreach ($this->authors as $index => $author) {
            if ($author->getId() === $id) {
                unset($this->authors[$index]);
                // Reindex the array to maintain consistent indices
                $this->authors = array_values($this->authors);
                return;
            }
        }
    }
    public function findByName(string $name): ?Author
    {
        foreach ($this->authors as $author) {
            if (strtolower(trim($author->getFullName())) === strtolower(trim($name))) {
                return $author;
            }
        }
        return null;
    }
}
