<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

// Check if the user is logged in and set a variable for the agency ID
$agency_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($agency_id) {
    echo "Agency ID from session: " . $agency_id; // Check the ID stored in the session
} else {
    echo "No user is logged in.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = authenticateUser($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials.";
    }
}

include 'includes/header.php'; 
?>

<div class="login-form">
    <h2>Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </form>
</div>

<?php include 'includes/footer.php'; ?>