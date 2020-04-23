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
        if (count($viewbag["json"]) != 0) {
            for ($i = 0; $i < count($viewbag["json"]); $i++) {
                ?>
                <option value="<?php echo $i ?>">Machine <?php echo $i ?></option>
                <?php
            }
        } else {
            ?>
            <option value="error">No available machines</option>
            <?php
        }
        ?>
    </select>

    <br><br>

    <label for="machineid">Machine ID:</label>
    <input type="text" id="machineid" value="<?php if (isset($_GET["machinelist"])) { echo $viewbag["json"][$_GET["machinelist"]]["machineID"]; } ?>" readonly><br><br>
    <label for="hostname">Hostname:</label>
    <input type="text" id="hostname" value="<?php if (isset($_GET["machinelist"])) { echo $viewbag["json"][$_GET["machinelist"]]["hostname"]; } ?>" readonly><br><br>
    <label for="port">Port:</label>
    <input type="text" id="port" value="<?php if (isset($_GET["machinelist"])) { echo $viewbag["json"][$_GET["machinelist"]]["port"]; } ?>" readonly><br><br>

    <input type="submit" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/chooseMachine')" value="Choose">
</form>
</body>
</html>