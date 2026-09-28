<!-- Code for deleting an existing notice -->
<?php
require_once 'config/db.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM notices WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
}

header('Location: index.php');
exit;
?>