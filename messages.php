<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipient_id = $_POST['recipient_id'];
    $message_content = $_POST['message_content'];

    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, recipient_id, content) VALUES (:sender_id, :recipient_id, :content)");
    $stmt->execute([
        'sender_id' => $_SESSION['user_id'],
        'recipient_id' => $recipient_id,
        'content' => $message_content
    ]);
}

$messages = [];
$stmt = $pdo->prepare("SELECT * FROM messages WHERE recipient_id = :recipient_id OR sender_id = :sender_id");
$stmt->execute(['recipient_id' => $_SESSION['user_id'], 'sender_id' => $_SESSION['user_id']]);
$messages = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="messages">
    <h2>Your Messages</h2>
    <form method="POST">
        <input type="