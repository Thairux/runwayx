<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $skills = $_POST['skills'];

    // Update user details
    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, skills = :skills WHERE id = :id");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'skills' => $skills,
        'id' => $_SESSION['user_id']
    ]);

    header("Location: profile.php"); // Redirect to the same page to see changes
    exit;
}

// Initialize variables to avoid undefined index warnings
$name = $user['name'] ?? '';
$email = $user['email'] ?? '';
$skills = $user['skills'] ?? '';

include 'includes/header.php'; 
?>

<h2>Your Profile</h2>
<form action="profile.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>

    <label for="skills">Skills:</label>
    <textarea name="skills" id="skills"><?php echo htmlspecialchars($skills); ?></textarea>

    <button type="submit">Update Profile</button>
</form>

<?php include 'includes/footer.php'; ?>