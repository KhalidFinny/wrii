<?php
require 'db.php';

if (isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        $result = $stmt->execute([$id]);
        if ($result) {
            header("Location: read.php?deleted=true");
        } else {
            header("Location: read.php?error=true");
        }
        exit;
    } catch(PDOException $e) {
        header("Location: read.php?error=true");
        exit;
    }
}

header("Location: read.php");
exit;
?>
