<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'agency') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Insert the new job into the database
    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, location, created_at) VALUES (:title, :description, :location, NOW())");
    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'location' => $location
    ]);

    header("Location: job-listings.php"); // Redirect to job listings after posting
    exit;
}

include 'includes/header.php'; 
?>

<h2>Post a New Job</h2>
<form action="post-job.php" method="POST">
    <label for="title">Job Title:</label>
    <input type="text" name="title" id="title" required>

    <label for="description">Job Description:</label>
    <textarea name="description" id="description" required></textarea>

    <label for="location">Location:</label>
    <input type="text" name="location" id="location" required>

    <button type="submit">Post Job</button>
</form>

<?php include 'includes/footer.php'; ?>