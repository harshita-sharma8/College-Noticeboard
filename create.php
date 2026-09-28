<!-- Code for Create a new notice  -->
<?php
require_once 'config/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']);
    $content     = trim($_POST['content']);
    $date_posted = trim($_POST['date_posted']);
    $category    = trim($_POST['category']);

    if (!empty($title) && !empty($content) && !empty($date_posted) && !empty($category)) {
        $stmt = $pdo->prepare("INSERT INTO notices (title, content, date_posted, category) VALUES (:title, :content, :date_posted, :category)");
        $stmt->execute([
            ':title'       => $title,
            ':content'     => $content,
            ':date_posted' => $date_posted,
            ':category'    => $category
        ]);
        header('Location: index.php');
        exit;
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post New Notice</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Post New Notice</h2>
        <?php if ($message): ?><p class="error"><?= htmlspecialchars($message); ?></p><?php endif; ?>

        <form method="POST" action="create.php">
            <label>Notice Title:</label>
            <input type="text" name="title" required placeholder="e.g. End Semester Exam Schedule">

            <label>Category:</label>
            <select name="category" required>
                <option value="">-- Select Category --</option>
                <option value="Events">Events</option>
                <option value="Holidays">Holidays</option>
                <option value="Notices">Notices</option>
                <option value="Placements">Placements</option>
                <option value="Internships">Internships</option>

            <label>Date Posted:</label>
            <input type="date" name="date_posted" value="<?= date('Y-m-d'); ?>" required>

            <label>Notice Content:</label>
            <textarea name="content" rows="5" required placeholder="Write details here..."></textarea>

            <button type="submit" class="btn btn-primary">Submit Notice</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>