<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chosen machine</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>
<body>
<p>Chosen machine:</p>

<form method="GET">
    <div>
        <label for="machineID">Machine ID:</label>
        <input type="text" id="machineID" name="machineID" value="<?php echo $_POST["machineID"] ?>" readonly><br><br>
    </div>
    <div>
        <label for="hostname">Hostname:</label>
        <input type="text" id="hostname" name="hostname" value="<?php echo $_POST["hostname"] ?>" readonly><br><br>
    </div>
    <div>
        <label for="port">Port:</label>
        <input type="text" id="port" name="port" value="<?php echo $_POST["port"] ?>" readonly><br><br>
    </div>
</form>
</body>
</html>