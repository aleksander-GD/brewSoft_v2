<!DOCTYPE html>
<html>

<head>
    <title>Edit batch</title>
    <?php include_once '../app/views/partials/head.php'; ?>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/editbatch.css">
    <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>
</head>
<?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
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

                <!-- <label for="productID" id="productid-label">Product ID: </label>
                <input type="text" name="productID" id="productID" value="<?php echo $viewbag['batch'][0]['productid'] ?>">
                <br> -->
                <label for="productID"> Choose product type: </label><br>
                <select name="productID" id="productID">

                    <?php foreach ($viewbag['products'] as $prod) { ?>
                        <option value="<?php echo $prod['productid']; ?>"><?php echo $prod['productname'];     ?></option>
                    <?php } ?>


                </select><br>

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
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>
