<?php
require('shared/auth.php');
try {
    // no html required as this is an invisible page
    // it deletes the travel plan then redirects to the updated list

    // identify which travel plan to remove. use $_GET to read the url param called "travelId"
    $travelId = $_GET['travelId'];

    // connect to db
    require('shared/db.php');

    // access control check: does the current user own this travel plan?
    $sql = "SELECT * FROM travels WHERE travelId = :travelId";
    $cmd = $db->prepare($sql);

    // populate the SQL with the selected travelId
    $cmd->bindParam(':travelId', $travelId, PDO::PARAM_INT);

    // execute query in the database
    $cmd->execute();
    $travelPlan = $cmd->fetch();

    // ownership check
    if ($travelPlan['user'] != $_SESSION['user']) {
        $db = null;
        header('location:403.php'); // forbidden
        exit();
    }

    // create SQL delete statement
    $sql = "DELETE FROM travels WHERE travelId = :travelId";
    $cmd = $db->prepare($sql);

    // populate the SQL delete with the selected travelId
    $cmd->bindParam(':travelId', $travelId, PDO::PARAM_INT);

    // execute delete in the database
    $cmd->execute();

    // disconnect 
    $db = null;

    // redirect to updated list
    header('location:Schedule.php');
} catch (Exception $error) {
    header('location:error.php');
    exit();
}

?>