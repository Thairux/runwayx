<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];

    // Fetch job details (optional)
    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE id = :job_id");
    $stmt->execute(['job_id' => $job_id]);
    $job = $stmt->fetch();
} else {
    header("Location: job-listings.php"); // Redirect if no job ID is provided
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cover_letter = $_POST['cover_letter'];

    // Insert the application into the database with initial status
    $stmt = $pdo->prepare("INSERT INTO applications (job_id, model_id, cover_letter, status) VALUES (:job_id, :model_id, :cover_letter, 'Applied')");
    $stmt->execute([
        'job_id' => $job_id,
        'model_id' => $_SESSION['user_id'],
        'cover_letter' => $cover_letter
    ]);

    // Add notification logic
    $job_title = $job['title']; // Get the actual job title from the fetched job
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'message' => 'You have successfully applied for the job: ' . $job_title
    ]);

    header("Location: job-application-status.php"); // Redirect to application status page
    exit;
}
?>

<!-- HTML form for applying -->
<h2>Apply for <?php echo htmlspecialchars($job['title']); ?></h2>
<form action="job-apply.php?job_id=<?php echo $job_id; ?>" method="POST">
    <label for="cover_letter">Cover Letter:</label>
    <textarea name="cover_letter" id="cover_letter" required placeholder="Write your cover letter here..."></textarea>

    <button type="submit">Apply</button>
</form>