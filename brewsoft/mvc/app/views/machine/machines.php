<!DOCTYPE html>
<html lang="en">
<head>
    <body>
    <title>Available Machines</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<p>Available machines:</p>

<form id="machineform">
    <select id="machines" name="machinelist" form="machineform">
        <?php
        if (count($viewbag["availableMachines"]) != 0) {
            for ($i = 0; $i < count($viewbag["availableMachines"]); $i++) {
                ?>
                <option value="<?php echo $i ?>"<?php if (isset($_GET["machinelist"]) && $_GET["machinelist"] == $i) {echo "selected";} ?>>Machine <?php echo $i+1 ?></option>
                <?php
            }
        } else {
            ?>
            <option value="error">No available machines</option>
            <?php
        }
        ?>
    </select>
    <input type="submit" class="item" value="Choose">
</form>
    <br><br>
    <?php
    if (isset($_GET["machinelist"])) {
        ?>
        <form action="/brewsoft/mvc/public/machineapi/chooseMachine" method="POST">
            <label for="machineID">Machine ID:</label>
            <input type="text" id="machineID" name="machineID" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["brewerymachineid"];
            } ?>" readonly><br><br>
            <label for="hostname">Hostname:</label>
            <input type="text" id="hostname" name="hostname" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["hostname"];
            } ?>" readonly><br><br>
            <label for="port">Port:</label>
            <input type="text" id="port" name="port" value="<?php if (isset($_GET["machinelist"])) {
                echo $viewbag["availableMachines"][$_GET["machinelist"]]["port"];
            } ?>" readonly><br><br>

            <input type="submit" class="item" value="Confirm">
        </form>
        <?php
    }
    ?>
</body>
</html>