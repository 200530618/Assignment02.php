<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- normalize to remove browser default styles -->
    <link rel="stylesheet" href="css/normalize.css" />
    <!-- our custom css -->
    <link rel="stylesheet" href="css/app.css" />
    <!-- our custom js -->
    <script src="js/scripts.js" defer></script>
</head>
<body>
    <header>
        <h1>
            <a href="index.php">
                Safe Travels
            </a>
        </h1>
        <nav>
            <ul>
                <li><a href="Schedule.php">Schedule</a></li>
                <?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                    
                if (empty($_SESSION['user'])) {
                    echo '<li><a href="registration.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>';
                }
                else {
                    echo '<li><a href="#">' . $_SESSION['user'] . '</a></li>
                    <li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>