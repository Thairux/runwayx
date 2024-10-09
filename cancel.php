<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    $stmt = $pdo->prepare("DELETE FROM applications WHERE job_id = :job_id AND model_id = :model_id");
    $stmt->execute(['job_id' => $job_id, 'model_id' => $_SESSION['user_id']]);
}

header("Location: calendar.php");
exit;