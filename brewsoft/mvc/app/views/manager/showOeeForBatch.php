<!DOCTYPE html>
<html>

<head>
    <title>Show Oee for batch</title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/oeeforbatch.css">
    <?php include_once '../app/views/partials/head.php'; ?>
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

    <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>
    <?php include '../app/views/partials/foot.php'; ?>
