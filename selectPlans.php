<?php
// authentication check: this page is now private
require('shared/auth.php');

$title = 'Select Your Travel Plan';
require('shared/header.php');
?>
<main>
    <h1>Select your travel Plans</h1>
    <form action="savePlans.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <label for="location">Location:</label>
            <select name="location" id="location" required>
                <option value="">Select a location</option>
                <option value="Paris">Paris</option>
                <option value="Tokyo">Tokyo</option>
                <option value="New York">New York</option>
                <option value="London">London</option>
                <option value="New Delhi">New Delhi</option>
                <option value="Sydney">Sydney</option>

            </select>
        </fieldset>
        <fieldset>
            <label for="days">Number of Days:</label>
            <select name="days" id="days" required>
                <option value="">Select number of days</option>
                <option value="Fifteen Day">Fifteen Day</option>
                <option value="Seven Days">Seven Days</option>
                <option value="Twenty Days">Twenty Days</option>

            </select>
        </fieldset>
        <button class="btnOffset">Create</button>
    </form>
</main>
<?php require('shared/footer.php'); ?>