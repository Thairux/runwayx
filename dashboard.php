<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

// Fetch applied jobs
$stmt = $pdo->prepare("SELECT jobs.title, applications.created_at FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.model_id = :model_id");
$stmt->execute(['model_id' => $user_id]);
$applied_jobs = $stmt->fetchAll();

// Fetch messages
$stmt = $pdo->prepare("SELECT * FROM messages WHERE recipient_id = :recipient_id OR sender_id = :sender_id");
$stmt->execute(['recipient_id' => $user_id, 'sender_id' => $user_id]);
$messages = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="dashboard">
    <h2>Welcome, <?php echo $user['username']; ?></h2>
    
    <h3>Your Applied Jobs</h3>
    <ul>
        <?php foreach ($applied_jobs as $job): ?>
            <li><?php echo $job['title']; ?> - Applied on <?php echo $job['created_at']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Your Messages</h3>
    <ul>
        <?php foreach ($messages as $message): ?>
            <li><?php echo $message['content']; ?> - <em><?php echo $message['created_at']; ?></em></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>
