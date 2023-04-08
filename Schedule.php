<?php
$title = 'Travel Plans'; // set page title BEFORE linking header as header expects this var
require('shared/header.php');
?>
<main>
    <h1>Travel Plans</h1>
    <?php
    if (!empty($_SESSION['user'])) {
        echo '<a href="selectPlans.php">Add a New Travel Plan</a>';
    }
    try {
        // connect to db
        require('shared/db.php');

        // set up the SQL SELECT command
        $sql = "SELECT * FROM travels ORDER BY travelId DESC";

        // if there is a user param in the url, use it as a filter
        if (!empty($_GET['user'])) {
            $sql = "SELECT * FROM travels WHERE user = :user 
                     ORDER BY travelId DESC";
        }

        // execute the select query
        $cmd = $db->prepare($sql);

        // bind the username param if viewing 1 user's travel plans only
        if (!empty($_GET['user'])) {
            $cmd->bindParam(':user', $_GET['user'], PDO::PARAM_STR, 50);
        }

        $cmd->execute();

        // store the query results in an array. use fetchAll for multiple records, fetch for 1.
        $travels = $cmd->fetchAll();

        echo '<table>';
        echo '<thead><th>User Name</th><th>Location</th><th>Number Of Days</th></thead>';

        // display travel plan data in a loop. $travels = all data, $travel = the current item in the loop
        foreach ($travels as $travel) {
            echo '<tr>'; //create a new row
    
            echo '<td>' . $travel['user'] . '</td>'; //create a new column w/data inside
            echo '<td>' . $travel['location'] . '</td>';
            echo '<td>' . $travel['days'] . '</td>';
            echo '</tr>';

            // access check. 1 - is user logged in?  2. does user own this travel plan?
            if (!empty($_SESSION['user'])) {
                if ($travel['user'] == $_SESSION['user']) {
                    echo '<a href="edit.php?travelId=' . $travel['travelId'] . '">Edit</a>
                        <a onclick="return confirmDelete();"
                        href="deleteSchedule.php?travelId=' . $travel['travelId'] . '
                        ">Delete</a>';
                }
            }

            echo '</article>';
        }

        // disconnect
        $db = null;
    } catch (Exception $error) {
        header('location:error.php');
        exit();
    }
    ?>
</main>
<?php require('shared/footer.php'); ?>