<?php
session_start();
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: search.php");
    exit;
}

$job_id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = :id");
$stmt->execute(['id' => $job_id]);
$job = $stmt->fetch();

include 'includes/header.php'; 
?>

<div class="job-details">
    <h2><?php echo $job['title']; ?></h2>
    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
    <p><strong>Description:</strong> <?php echo $job['description']; ?></p>
    <p><strong>Posted by:</strong> Agency ID <?php echo $job['agency_id']; ?></p>
    <a href="job-apply.php?id=<?php echo $job['id']; ?>">Apply for this job</a>
</div>

<?php include 'includes/footer.php'; ?>