<?php
require('shared/auth.php');

$title = 'Edit your Travel Plan';
require('shared/header.php');
?>
<main>
    <?php
    try {
        // get the travelId from the url parameter using $_GET
        $travelId = $_GET['travelId'];
        if (empty($travelId)) {
            header('location:404.php');
            exit();
        }

        // connect - we can re-use for the 2nd query later
        require('shared/db.php');

        // set up & run SQL query to fetch the selected travel plan record.  fetch for 1 record only
        $sql = "SELECT * FROM travels WHERE travelId = :travelId";
        $cmd = $db->prepare($sql);
        $cmd->bindParam(':travelId', $travelId, PDO::PARAM_INT);
        $cmd->execute();
        $travel = $cmd->fetch();

        // check query returned a valid travel plan record
        if (empty($travel)) {
            header('location:404.php');
            exit();
        }

        // access control check: is logged user the owner of this travel plan?
        if ($travel['user'] != $_SESSION['user']) {
            header('location:403.php'); // 403 = HTTP Forbidden Error
            exit();
        }
    } catch (Exception $error) {
        header('location:error.php');
        exit();
    }
    ?>
    <h1>Edit Travel Plan</h1>
    <form action="update.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="location">Location:</label>
            <select name="location" id="location" required>
                <option value="">Select a location</option>
                <option value="Paris" <?php if ($travel['location'] == 'Paris') {
                    echo 'selected';
                } ?>>Paris</option>
                <option value="Tokyo" <?php if ($travel['location'] == 'Tokyo') {
                    echo 'selected';
                } ?>>Tokyo</option>
                <option value="New York" <?php if ($travel['location'] == 'New York') {
                    echo 'selected';
                } ?>>New York
                </option>
                <option value="London" <?php if ($travel['location'] == 'London') {
                    echo 'selected';
                } ?>>London</option>
                <option value="New Delhi" <?php if ($travel['location'] == 'New Delhi') {
                    echo 'selected';
                } ?>>New Delhi
                </option>
                <option value="Sydney" <?php if ($travel['location'] == 'Sydney') {
                    echo 'selected';
                } ?>>Sydney</option>
            </select>
        </fieldset>
        <fieldset>
            <label for="days">Number of Days:</label>
            <select name="days" id="days" required>
                <option value="">Select number of days</option>
                <option value="Fifteen Day" <?php if ($travel['days'] == 'Fifteen Day') {
                    echo 'selected';
                } ?>>Fifteen Day
                </option>
                <option value="Seven Days" <?php if ($travel['days'] == 'Seven Days') {
                    echo 'selected';
                } ?>>Seven Days
                </option>
                <option value="Twenty Days" <?php if ($travel['days'] == 'Twenty Days') {
                    echo 'selected';
                } ?>>Twenty Days
                </option>
            </select>
        </fieldset>
        <button class="btnOffset">Update</button>
        <input name="travelId" id="travelId" value="<?php echo $travelId; ?>" type="hidden" />
        <input name="currentLocation" value="<?php echo $travel['location']; ?>" type="hidden" />
        <input name="currentDays" value="<?php echo $travel['days']; ?>" type="hidden" />
    </form>
</main>
<?php require('shared/footer.php'); ?>