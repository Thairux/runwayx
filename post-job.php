<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$agency_id = $_SESSION['user_id'];

// Check if the agency ID exists in the users table
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $agency_id]);
$agency = $stmt->fetch();

if (!$agency) {
    die("Error: Agency ID does not exist.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];

    // Insert the new job into the database
    $stmt = $pdo->prepare("INSERT INTO jobs (title, description, location, created_at, agency_id) VALUES (:title, :description, :location, NOW(), :agency_id)");
    $stmt->execute([
        'title' => $title,
        'description' => $description,
        'location' => $location,
        'agency_id' => $agency_id // Use the valid agency ID
    ]);

    header("Location: job-listings.php");
    exit;
}

include 'includes/header.php'; 
?>

<div class="post-job-form">
    <h2>Post a Job</h2>
    <form method="POST">
        <input type="text" name="title" placeholder="Job Title" required>
        <textarea name="description" placeholder="Job Description" required></textarea>
        <input type="text" name="location" placeholder="Location" required>
        <button type="submit">Post Job</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>