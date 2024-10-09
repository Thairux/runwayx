<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user's applications
$stmt = $pdo->prepare("SELECT a.*, j.title FROM applications a JOIN jobs j ON a.job_id = j.id WHERE a.model_id = :model_id");
$stmt->execute(['model_id' => $_SESSION['user_id']]);
$applications = $stmt->fetchAll();

include 'includes/header.php'; 
?>

<h2>Your Job Applications</h2>
<table>
    <thead>
        <tr>
            <th>Job Title</th>
            <th>Cover Letter</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['title']); ?></td>
                <td><?php echo htmlspecialchars($application['cover_letter']); ?></td>
                <td><?php echo htmlspecialchars($application['status']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include 'includes/footer.php'; ?>