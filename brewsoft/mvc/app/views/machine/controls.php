<!DOCTYPE html>

<header>
    <title>Machine Control</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src=""></script>
    <html lang="en">
</header>

<p>Machine buttons:</p>

<form method="post">
    <div>
        <input type="button" class="item" onclick="location.replace(/machineapi/startProduction)" value="Start Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace(/machineapi/stopProduction)" value="Stop Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace(/machineapi/abortMachine)" value="Abort Production">
    </div>
    <div>
        <input type="button" class="item" onclick="location.replace(/machineapi/clearMachine)" value="Clear State">
    </div>
    <div>
       <input type="button" class="item" onclick="location.replace(/machineapi/resetMachine)" value="Reset Machine">
    </div>
</form>
</html>