<?php
// auth check
require('shared/auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saving your Plans...</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/app.css" />
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
                <li><a href="register.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
        try {
            // capture the form input using the $_POST array & store in variables
            $location = $_POST['location'];
            $user = $_SESSION['user']; //$_POST['user'];
            $days = $_POST['days'];

            // lesson 4 - add validation before saving. Check 1 at a time for descriptive errors.
            $ok = true; // start with no validation errors
        
            if (empty($location)) {
                echo '<p class="error">Location is required.</p>';
                $ok = false; // error happened - bad data
            }

            if (empty($user)) {
                echo '<p class="error">User is required.</p>';
                $ok = false; // error happened - bad data
            }

            if (empty($days)) {
                echo '<p class="error">Number of days is required.</p>';
                $ok = false; // error happened - bad data
            }

            // only save to db if $ok has never been changed to false
            if ($ok == true) {
                // connect to the db using the PDO library
                require('shared/db.php');

                // set up an SQL INSERT
                $sql = "INSERT INTO travels (location, user, days) VALUES 
                (:location, :user, :days)";

                // map each input to the corresponding db column
                $cmd = $db->prepare($sql);
                $cmd->bindParam(':location', $location, PDO::PARAM_STR, 50);
                $cmd->bindParam(':user', $user, PDO::PARAM_STR, 100);
                $cmd->bindParam(':days', $days, PDO::PARAM_STR, 20);

                // execute the insert
                $cmd->execute();

                // disconnect
                $db = null;

                // show the user a message
                echo '<h1>Travel plan saved</h1>
                    <p><a href="Schedule.php">See the updated list of travel plans</a></p>';
            }
        } catch (Exception $error) {
            header('location:error.php');
            exit();
        }
        ?>
    </main>
</body>

</html>