<!DOCTYPE html>
<html lang="en">
<head>
    <title>Machine Control</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="../js/machineApi.js"></script>
</head>
<pre>
<?php //var_dump($viewbag); ?>
</pre>
<div>
<?php
if(!empty($viewbag["error"])) {
  echo "Error: ";
  foreach ($viewbag["error"] as $key => $value) {
    echo "<span>".$value."</span>";
  }
}
?>
<?php
if(!empty($viewbag["success"])) {
  echo "Success: ";
  foreach ($viewbag["success"] as $key => $value) {
    echo "<span>".$value."</span>";
  }
}
?>
</div>
<form name="controlForm" id="controlForm" action="" method="post" onsubmit="">
<p>Machines:</p>
<?php include '../app/views/machine/machines.php'; ?>
<p>Machine controls:</p>
<input type="hidden" value="" name="command" id="command">
<?php
  $commands = "";
  foreach ($viewbag["controls"]->commands as $key => $value) {
    echo "<button type='submit' form='controlForm' onclick='changeCommand(this);' value='$value'>$value</button>";
  }
?>
</form>
<!--form method="post">
    <div>
        <input type="button" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/startProduction')" value="Start Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/stopProduction')" value="Stop Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/abortMachine')" value="Abort Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/clearMachine')" value="Clear State">
    </div>
    <div>
       <input type="button" class="item" onclick="location.replace('/brewsoft/mvc/public/machineapi/resetMachine')" value="Reset Machine">
    </div>
</form-->
</body>
</html>
