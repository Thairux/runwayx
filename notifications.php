<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Mark notification as read if an ID is provided
if (isset($_GET['id'])) {
    $notification_id = $_GET['id'];
    $stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = :id");
    $stmt->execute(['id' => $notification_id]);
}

// Fetch notifications
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $user_id]);
$notifications = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="notifications">
    <h2>Your Notifications</h2>
    <ul>
        <?php foreach ($notifications as $notification): ?>
            <li>
                <?php echo $notification['message']; ?> - <em><?php echo $notification['created_at']; ?></em>
                <?php if (!$notification['is_read']): ?>
                    <a href="notifications.php?id=<?php echo $notification['id']; ?>">Mark as read</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>