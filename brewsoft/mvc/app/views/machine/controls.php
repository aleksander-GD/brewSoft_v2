<!DOCTYPE html>
<html lang="en">
<head>
    <body>
    <title>Machine Control</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<p>Machine buttons:</p>

<form method="post">
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
</form>
</body>
</html>