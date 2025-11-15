<?php
require_once __DIR__ . '/vendor/autoload.php';

use Mjoma\PhpClass\BookRepository;

$repo = new BookRepository();
$books = $repo->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Books</title>
    <meta charset="UTF-8">
    </head>
<body>
    <h1>All Books</h1>
<p><a href="index.php">Back to Home</a></p>
<?php if (empty($books)): ?>
    <p>No books available.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
        </tr>
        <?php foreach ($books as $book): ?>
            <tr>
                <td><?php echo htmlspecialchars($book->getId()); ?></td>
                <td><?php echo htmlspecialchars($book->getTitle()); ?></td>
                <td><?php
                    $author = $book->getAuthor();
            echo htmlspecialchars($author->getFirstName() . ' ' . $author->getLastName());
            ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</body>
</html>
