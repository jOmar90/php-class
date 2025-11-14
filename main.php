<?php

require_once __DIR__ . '/vendor/autoload.php';

use Mjoma\PhpClass\Author;
use Mjoma\PhpClass\Book;
use Mjoma\PhpClass\AuthorRepository;
use Mjoma\PhpClass\BookRepository;

echo "Loaded all files...\n";

class Main
{
    private AuthorRepository $authorRepository;
    private BookRepository $bookRepository;

    public function __construct()
    {
        $this->authorRepository = new AuthorRepository();
        $this->bookRepository = new BookRepository();
    }

    public function showMainMenu()
    {
        while (true) {
            echo "\n=== Book and Author Management System ===\n";
            echo "1. Add Author\n";
            echo "2. Add Book\n";
            echo "3. Show All Authors\n";
            echo "4. Show All Books\n";
            echo "5. Show Books by Author\n";
            echo "6. Remove Author\n";
            echo "7. Remove Book\n";
            echo "8. Exit\n";

            $choice = readline("Choose an option: ");
            match ($choice) {
                '1' => $this->handleAddAuthor(),
                '2' => $this->handleAddBook(),
                '3' => $this->showAllAuthors(),
                '4' => $this->showAllBooks(),
                '5' => $this->handleSearchByAuthor(),
                '6' => $this->handleRemoveAuthor(),
                '7' => $this->handleRemoveBook(),
                '8' => exit("Goodbye!\n"),
                default => print "Invalid choice. Please try again.\n",
            };
        }
    }

    // Add a new author
    public function handleAddAuthor()
    {
        echo "\n--- Add a New Author ---\n";
        $firstName = readline("Enter author's first name: ");
        $lastName = readline("Enter author's last name: ");
        $dateOfBirthInput = readline("Enter author's date of birth (YYYY-MM-DD): ");
        $dateOfBirth = new DateTimeImmutable($dateOfBirthInput);

        $id = count($this->authorRepository->getAll()) + 1; // Auto increment
        $author = new Author($id, $firstName, $lastName, $dateOfBirth);
        $this->authorRepository->add($author);

        echo "Author added successfully!\n";
    }

    // Add a new book
    public function handleAddBook()
    {
        echo "\n--- Add a New Book ---\n";

        // Ask for book info
        $title = readline("Enter book title: ");
        $authorName = readline("Enter author name: ");
        $isbn = readline("Enter ISBN: ");
        $publisher = readline("Enter publisher: ");
        $publicationDate = readline("Enter publication date (YYYY-MM-DD): ");
        $pages = readline("Enter number of pages: ");

        // Look up the Author object
        $authorObject = $this->authorRepository->findByName($authorName);

        if (!$authorObject) {
            echo "Author not found. Please add the author first.\n";
            return; // stop if author does not exist
        }

        // Auto-increment book ID
        $id = count($this->bookRepository->getAll()) + 1;

        // Create the Book object
        $book = new Book($id, $title, $authorObject, $isbn, $publisher, $publicationDate, $pages);

        // Add the book to the repository
        $this->bookRepository->add($book);

        echo "Book added successfully!\n";
    }


    // Show all authors
    public function showAllAuthors()
    {
        echo "\n--- List of Authors ---\n";
        $authors = $this->authorRepository->getAll();
        if (empty($authors)) {
            echo "No authors available yet. Add some authors first!\n";
            return;
        }

        foreach ($authors as $author) {
            echo "ID: {$author->getId()}, Name: {$author->getFullName()}, Born: {$author->getDateOfBirthAsString()}\n";
        }
    }

    // Show all books
    public function showAllBooks()
    {
        echo "\n--- List of Books ---\n";
        $books = $this->bookRepository->getAll();
        if (empty($books)) {
            echo "No books available yet. Add some books first!\n";
            return;
        }

        foreach ($books as $book) {
            echo "ID: {$book->getId()}, Title: {$book->getTitle()}, Author: {$book->getAuthor()->getFullName()}\n";
        }
    }

    // Search books by author name
    public function handleSearchByAuthor()
    {
        echo "\n--- Search by Author ---\n";
        $name = readline("Enter author name: ");

        $author = $this->authorRepository->findByName($name);

        if ($author) {
            $books = $this->bookRepository->getBookByAuthor($author->getId());
            if (empty($books)) {
                echo "No books found for {$author->getFullName()}.\n";
            } else {
                echo "Books by {$author->getFullName()}:\n";
                foreach ($books as $book) {
                    echo "- {$book->getTitle()}\n";
                }
            }
        } else {
            echo "Author not found.\n";
        }
    }

    // Remove author
    public function handleRemoveAuthor()
    {
        echo "\n--- Remove an Author ---\n";
        if (empty($this->authorRepository->getAll())) {
            echo "No authors available to remove.\n";
            return;
        }
        $id = readline("Enter author ID to remove: ");

        while (true) {
            $confirm = strtolower(trim(readline("Are you sure you want to remove author ID {$id}? (yes/no): ")));

            if ($confirm === "yes") {
                $this->authorRepository->remove($id);
                echo "Author removed.\n";
                break; // exit loop
            } elseif ($confirm === "no") {
                echo "Author removal cancelled.\n";
                break; // exit loop
            } else {
                echo "Invalid input. Please type 'yes' or 'no'.\n";
            }
        }
    }
    // Remove book
    public function handleRemoveBook()
    {
        echo "\n--- Remove a Book ---\n";
        if (empty($this->bookRepository->getAll())) {
            echo "No books available to remove.\n";
            return;
        }
        $id = readline("Enter book ID to remove: ");
        while (true) {
            $confirm = strtolower(trim(readline("Are you sure you want to remove book ID {$id}? (yes/no): ")));

            if ($confirm === "yes") {
                $this->bookRepository->remove($id);
                echo "Book removed.\n";
                break; // exit loop
            } elseif ($confirm === "no") {
                echo "Book removal cancelled.\n";
                break; // exit loop
            } else {
                echo "Invalid input. Please type 'yes' or 'no'.\n";
            }
        }
    }
}
$main = new Main();
$main->showMainMenu();
