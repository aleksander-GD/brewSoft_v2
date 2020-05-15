<!DOCTYPE html>
<html>

<head>
    <title>Show Oee for batch</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/oeeforbatch.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>

    <div>
        <p for="OEE">
            <?php
            if (!empty($viewbag['oeeForBatch'])) {
                echo 'Oee: ' . $viewbag['oeeForBatch'] . '&#37';
            }
            if (!empty($viewbag['availability'])) {
                echo "<br>" . 'availability: ' . $viewbag['availability'] . '&#37';
            }
            if (!empty($viewbag['performance'])) {
                echo "<br>" . 'performance: ' . $viewbag['performance'] . '&#37';
            }
            if (!empty($viewbag['quality'])) {
                echo "<br>" . 'quality: ' . $viewbag['quality'] . '&#37';
            } ?> </p><br>
    </div>
    <input type="button" class="canceleditbuttonshowoee" name="canceleditbuttonshowoee" value="Cancel"></input>

    <script src="../../js/batch.js"></script>
    <?php include '../app/views/partials/foot.php'; ?>