<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

// Check if the 'type' parameter is set
$jobType = isset($_GET['type']) ? $_GET['type'] : null;

// Prepare the query based on the job type
if ($jobType) {
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE type = :type");
    $stmt->execute(['type' => $jobType]);
} else {
    $stmt = $pdo->prepare("SELECT * FROM jobs");
    $stmt->execute();
}

$jobs = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<div class="search-form">
    <h2>Search Jobs</h2>
    <form method="POST">
        <input type="text" name="location" placeholder="Location" required>
        <button type="submit">Search</button>
    </form>
</div>

<div class="job-results">
    <h3>Job Listings</h3>
    <ul>
        <?php foreach ($jobs as $job): ?>
            <li><?php echo $job['title']; ?> - <a href="job-apply.php?id=<?php echo $job['id']; ?>">Apply</a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include 'includes/footer.php'; ?>