<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RunwayX</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js" defer></script>
</head>
<body>
<header>
<nav>
    <ul>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php else: ?>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="search.php">Search Jobs</a></li>
            <li><a href="messages.php">Messages</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="logout.php">Logout</a></li>

            <?php if ($_SESSION['role'] === 'agency'): ?>
                <li><a href="job-listings.php">My Posted Jobs</a></li> <!-- Link for agencies to view their jobs -->
                <li><a href="post-job.php">Post Job</a></li> <!-- Link for agencies to post jobs -->
            <?php else: ?>
                <li><a href="job-listings.php">Job Listings</a></li> <!-- Link for users to apply for jobs -->
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>
</header>
