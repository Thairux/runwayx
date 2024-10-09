<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Fetch all users
$stmt = $pdo->prepare("SELECT * FROM users");
$stmt->execute();
$users = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="admin-panel">
    <h2>Admin Panel</h2>
    <h3>Users</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?php echo $user['username']; ?> - <?php echo $user['role']; ?> - <a href="delete-user.php?id=<?php echo $user['id']; ?>">Delete</a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>