<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$scheduled_jobs = [];
$stmt = $pdo->prepare("SELECT jobs.title, jobs.location, applications.created_at FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.model_id = :model_id");
$stmt->execute(['model_id' => $_SESSION['user_id']]);
$scheduled_jobs = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="calendar">
    <h2>Your Scheduled Jobs</h2>
    <ul>
        <?php foreach ($scheduled_jobs as $job): ?>
            <li>
                <?php echo $job['title']; ?> at <?php echo $job['location']; ?> - <em>Scheduled on <?php echo $job['created_at']; ?></em>
                <a href="cancel.php?job_id=<?php echo $job['id']; ?>">Cancel</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>