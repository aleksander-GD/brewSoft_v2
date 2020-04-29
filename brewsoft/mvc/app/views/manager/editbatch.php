<!DOCTYPE html>
<html>

<head>
    <title>Edit batch</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/editbatch.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="../../js/batch.js"></script>

</head>

<body>
    <div class="editbatch-form-wrapper">
        <form method="POST" id="editform">
            <div class="" id="inner-form-container">

                <hr>
                <p> You are currently editing</p>
                <label for="batchID" id="batchID-label">batch ID: </label>
                <input type="text" name="batchID" id="batchID" placeholder="" value="<?php echo $viewbag['batch'][0]['batchid'] ?>" readonly>
                <br>
                <hr>

                <label for="productID" id="productid-label">Product ID: </label>
                <input type="text" name="productID" id="productID" value="<?php echo $viewbag['batch'][0]['productid'] ?>">
                <br>

                <label for="productAmount" id="productAmount-label">Product amount: </label>
                <input type="text" name="productAmount" id="productAmount" value="<?php echo $viewbag['batch'][0]['productamount'] ?>">
                <br>

                <label for="deadline" id="deadline-label">Deadline: </label>
                <input type="date" name="deadline" id="deadline" value="<?php echo $viewbag['batch'][0]['deadline'] ?>">
                <br>

                <label for="speed" id="speed-label">Speed: </label>
                <input type="text" name="speed" id="speed" value="<?php echo $viewbag['batch'][0]['speed'] ?>">
                <br>

                <input type="submit" class="editbutton" name="editbutton" value="Edit" onclick="submitEditBatch()"></input>
                <input type="button" class="canceleditbuttoneditbatch" name="canceleditbuttoneditbatch" value="Cancel"></input>
                <hr>
                <span id="editstatus"></span>

            </div>
        </form>
    </div>

</body>

</html>