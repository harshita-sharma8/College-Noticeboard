<!-- Our main code -->
 
<?php
require_once 'config/db.php';

// fetching the notice from database
$stmt = $pdo->query("SELECT * FROM notices ORDER BY date_posted DESC, id DESC");
$notices = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>College Notice Board</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>College Notice Board</h1>
        <!-- create a new notice  -->
        <a href="create.php" class="btn btn-primary">+ Post New Notice</a>

        <div class="notice-list">
            <!-- checking the notices are exist or not if yes it shows on the dashboard if no then it display "no notice found" -->
            <?php if (count($notices) > 0): ?>
                <!-- notices exist then it shows all information about notice category, date and content -->
                 <!-- give option of edit and delete -->
                <?php foreach ($notices as $notice): ?>
                    <div class="notice-card">
                        <h3><?= htmlspecialchars($notice['title']); ?></h3>
                        <p class="meta">
                            <span class="badge"><?= htmlspecialchars($notice['category']); ?></span> | 
                            <strong>Date Posted:</strong> <?= htmlspecialchars($notice['date_posted']); ?>
                        </p>
                        <p class="content"><?= nl2br(htmlspecialchars($notice['content'])); ?></p>
                        <div class="actions">
                            
                            <a href="edit.php?id=<?= $notice['id']; ?>" class="btn btn-edit">Edit</a>
                            <a href="delete.php?id=<?= $notice['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this notice?');">Delete</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No notices found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>