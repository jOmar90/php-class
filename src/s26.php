<?php
// ========== MODEL ==========
class Book
{
    private static int $count = 0; // Static counter to assign unique IDs to each book.
    private $title;
    private $author;
    private $isbn;
    private $publisher;
    private $publicationDate;
    private $pages;
    private int $id;

    public function __construct($title, $author, $isbn, $publisher, $publicationDate, $pages)
    {
        $this->id = ++static::$count; // Assigns a unique ID
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
    public function getAuthor()
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
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }
    public function getPages()
    {
        return $this->pages;
    }

    public function getSummary()
    {
        return "ID: {$this->id} | {$this->title} by {$this->author} ({$this->pages} pages)\n";
    }
}

// ========== REPOSITORY ==========
class BookRepository
{
    private $books = [];

    public function addBook(Book $book)
    {
        // DI: addBook expects a Book object, type hint ensures correctness
        $this->books[] = $book;
    }

    public function showAllBooks()
    {
        foreach ($this->books as $book) {
            echo $book->getSummary();
        }
    }

    public function removeBook($title)
    {
        foreach ($this->books as $index => $book) {
            if ($book->getTitle() === $title) {
                unset($this->books[$index]);
                echo "Book titled '$title' has been removed.\n";
                $this->books = array_values($this->books); // reindex array
                return true;
            }
        }
        echo "Book not found.\n";
        return false;
    }

    public function searchByAuthor($author)
    {
        while (true) {
            $author = trim($author);
            if (empty($author) || !preg_match("/^[a-zA-Z.\s]+$/", $author)) {
                echo "Invalid author name. Please use letters and spaces only.\n";
                $author = readline("Enter author name to search: ");
            } else {
                break;
            }
        }

        $foundBooks = [];
        foreach ($this->books as $book) {
            if ($book->getAuthor() === $author) {
                $foundBooks[] = $book;
            }
        }

        foreach ($foundBooks as $book) {
            echo $book->getSummary();
        }

        if (empty($foundBooks)) {
            echo "No books found by author '$author'.\n";
        }
    }
}

// ========== CONTROLLERS / HANDLERS ==========
function handleAddBook(BookRepository $repository) // DI: repository is injected
{
    echo "\n--- Add a New Book ---\n";
    $title = readline("Enter book title: ");
    $author = readline("Enter author: ");
    $isbn = readline("Enter ISBN: ");
    $publisher = readline("Enter publisher: ");
    $publicationDate = readline("Enter publication date: ");
    $pages = readline("Enter number of pages: ");

    $book = new Book($title, $author, $isbn, $publisher, $publicationDate, $pages);

    // DI: use the repository passed in instead of creating a new one
    $repository->addBook($book);
    echo "Book added successfully!\n";
}

function handleSearchByAuthor(BookRepository $repository) // DI: repository is injected
{
    echo "\n--- Search by Author ---\n";
    $author = readline("Enter author name to search: ");
    $repository->searchByAuthor($author);
}

function handleRemoveBook(BookRepository $repository) // DI: repository is injected
{
    echo "\n--- Remove a Book ---\n";
    $title = readline("Enter book title to remove: ");
    $repository->removeBook($title);
}

// ========== MAIN MENU ==========
$repository = new BookRepository(); // one shared repository object for DI

while (true) {
    echo "\n--- Library Management ---\n";
    echo "1. Add Book\n";
    echo "2. Show All Books\n";
    echo "3. Remove Book\n";
    echo "4. Search by Author\n";
    echo "5. Exit\n";

    $choice = readline("Choose an option: ");

    match ($choice) {
        "1" => handleAddBook($repository), // repository injected
        "2" => $repository->showAllBooks(),
        "3" => handleRemoveBook($repository), // repository injected
        "4" => handleSearchByAuthor($repository), // repository injected
        "5" => exit("Goodbye!\n"),
        default => print "Invalid input, try again! ",
    };
}
