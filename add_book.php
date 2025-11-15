<?php
require_once __DIR__ . '/vendor/autoload.php';
use Mjoma\PhpClass\BookRepository;
use Mjoma\PhpClass\AuthorRepository;
use Mjoma\PhpClass\Book;

$bookRepo = new BookRepository();
$authorRepo = new AuthorRepository();

$authors = $authorRepo->getAll();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST["title"] ?? "";
    $authorId = isset($_POST["author_id"]) ? (int)$_POST["author_id"] : 0;
    "";
    $isbn = $_POST["isbn"] ?? "";
    $publisher = $_POST["publisher"] ?? "";
    $publicationDate = $_POST["publication_date"] ?? "";
    $pages = isset($_POST["pages"]) ? (int)$_POST["pages"] : 0;
    "";

    $id = count($bookRepo->getAll()) + 1; // Auto increment
    $book = new Book($id, $title, $authorRepo->get($authorId), $isbn, $publisher, new DateTimeImmutable($publicationDate), $pages);
    $bookRepo->add($book);
    header("Location: show_books.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Book</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>Add a New Book</h1>
    <p><a href="index.php">Back to Home</a></p>
    <form method="POST" action="add_book.php">
        <label for="title">Book Title:</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="author_id">Author:</label><br>
        <select id="author_id" name="author_id" required>
            <?php foreach ($authors as $author): ?>
                <option value="<?php echo htmlspecialchars($author->getId()); ?>">
                    <?php echo htmlspecialchars($author->getFirstName() . ' ' . $author->getLastName()); ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn" required><br><br>

        <label for="publisher">Publisher:</label><br>
        <input type="text" id="publisher" name="publisher" required><br><br>

        <label for="publication_date">Publication Date (YYYY-MM-DD):</label><br>
        <input type="date" id="publication_date" name="publication_date" required><br><br>

        <label for="pages">Number of Pages:</label><br>
        <input type="number" id="pages" name="pages" required><br><br>

        <button type="submit" value="Add Book">Add Book</button>
    </form>
    <!-- <p><a href="index.php">Back to Home</a></p> -->
</body>
</html>
