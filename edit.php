<!-- Code for edit an existing notice -->
<?php
require_once 'config/db.php';

$message = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM notices WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $notice = $stmt->fetch();

    if (!$notice) {
        die("Notice not found.");
    }
} else {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title']);
    $content     = trim($_POST['content']);
    $date_posted = trim($_POST['date_posted']);
    $category    = trim($_POST['category']);

    if (!empty($title) && !empty($content) && !empty($date_posted) && !empty($category)) {
        $stmt = $pdo->prepare("UPDATE notices SET title = :title, content = :content, date_posted = :date_posted, category = :category WHERE id = :id");
        $stmt->execute([
            ':title'       => $title,
            ':content'     => $content,
            ':date_posted' => $date_posted,
            ':category'    => $category,
            ':id'          => $id
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
    <title>Edit Notice</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Notice</h2>
        <?php if ($message): ?><p class="error"><?= htmlspecialchars($message); ?></p><?php endif; ?>

        <form method="POST" action="edit.php?id=<?= $notice['id']; ?>">
            <label>Notice Title:</label>
            <input type="text" name="title" value="<?= htmlspecialchars($notice['title']); ?>" required>

            <label>Category:</label>
            <select name="category" required>
                <option value="Events" <?= $notice['category'] === 'Events' ? 'selected' : ''; ?>>Events</option>
                <option value="Holidays" <?= $notice['category'] === 'Holidays' ? 'selected' : ''; ?>>Holidays</option>
                <option value="Notices" <?= $notice['category'] === 'Notices' ? 'selected' : ''; ?>>Notices</option>
                <option value="Placements" <?= $notice['category'] === 'Placements' ? 'selected' : ''; ?>>Placements</option>
                <option value="Internships" <?= $notice['category'] === 'Internships' ? 'selected' : ''; ?>>Internships</option>
            </select>

            <label>Date Posted:</label>
            <input type="date" name="date_posted" value="<?= htmlspecialchars($notice['date_posted']); ?>" required>

            <label>Notice Content:</label>
            <textarea name="content" rows="5" required><?= htmlspecialchars($notice['content']); ?></textarea>

            <button type="submit" class="btn btn-primary">Update Notice</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>