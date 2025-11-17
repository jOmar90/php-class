<?php
require_once __DIR__ . '/vendor/autoload.php';
use Mjoma\PhpClass\AuthorRepository;
use Mjoma\PhpClass\Author;

$authorRepo = new AuthorRepository();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST["first_name"] ?? "";
    $lastName = $_POST["last_name"] ?? "";
    $dateOfBirth = $_POST["date_of_birth"] ?? "";

    $id = count($authorRepo->getAll()) + 1; // Auto increment
    try {
        $author = new Author($id, $firstName, $lastName, new DateTimeImmutable($dateOfBirth));
        $authorRepo->add($author);
        $success = "Author added successfully.";
        header("Location: index.php");
        exit();
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Author</title>
</head>
<body>
    <h1>Add a New Author</h1>
    <p><a href="index.php">Back to Home</a></p>
    <?php if (!empty($success)): ?>
        <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
    <?php endif; ?>
    <?php if (!empty($errorMessage)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($errorMessage); ?></p>
    <?php endif; ?>
    <form method="POST" action="add_author.php">
        <label for="first_name">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="date_of_birth">Date of Birth (YYYY-MM-DD):</label><br>
        <input type="date" id="date_of_birth" name="date_of_birth" required><br><br>

        <button type="submit" value="Add Author">Submit Author</button>
    </form>
</body>
</html>
