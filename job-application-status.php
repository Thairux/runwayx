<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$job_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM applications WHERE job_id = :job_id AND model_id = :model_id");
$stmt->execute(['job_id' => $job_id, 'model_id' => $_SESSION['user_id']]);
$application = $stmt->fetch();

include 'includes/header.php'; 
?>

<div class="application-status">
    <h2>Application Status for Job ID: <?php echo $job_id; ?></h2>
    <?php if ($application): ?>
        <p>Your application was submitted on <?php echo $application['created_at']; ?>.</p>
        <p>Cover Letter: <?php echo $application['cover_letter']; ?></p>
    <?php else: ?>
        <p>You have not applied for this job.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>