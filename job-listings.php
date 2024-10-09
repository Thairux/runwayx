<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch jobs based on user role
if ($_SESSION['role'] === 'agency') {
    // Fetch jobs posted by the agency
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE agency_id = :agency_id"); // Ensure you have an agency_id in the jobs table
    $stmt->execute(['agency_id' => $_SESSION['user_id']]);
} else {
    // Fetch all job listings for users
    $stmt = $pdo->prepare("SELECT * FROM jobs");
    $stmt->execute();
}
$jobs = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="job-listings">
    <h2><?php echo ($_SESSION['role'] === 'agency') ? 'My Posted Jobs' : 'Available Job Listings'; ?></h2>
    <ul>
        <?php foreach ($jobs as $job): ?>
            <li>
                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                <p><?php echo htmlspecialchars($job['description']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                <p><strong>Posted on:</strong> <?php echo htmlspecialchars($job['created_at']); ?></p>
                
                <?php if ($_SESSION['role'] !== 'agency'): ?>
                    <a href="job-apply.php?job_id=<?php echo $job['id']; ?>" class="apply-button">Apply Now</a> <!-- Apply button for users -->
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>