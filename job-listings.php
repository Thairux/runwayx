<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all job listings
$stmt = $pdo->prepare("SELECT * FROM jobs");
$stmt->execute();
$jobs = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="job-listings">
    <h2>Available Job Listings</h2>
    <ul>
        <?php foreach ($jobs as $job): ?>
            <li>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                <p><strong>Posted on:</strong> <?php echo htmlspecialchars($job['created_at']); ?></p>
                <a href="job-apply.php?job_id=<?php echo $job['id']; ?>" class="apply-button">Apply Now</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>