 
<?php
session_start();
include 'includes/db.php';

$jobs = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $_POST['location'];
    $type = $_POST['type'];

    $stmt = $pdo->prepare("SELECT * FROM jobs WHERE location = :location");
    $stmt->execute(['location' => $location]);
    $jobs = $stmt->fetchAll();
}

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