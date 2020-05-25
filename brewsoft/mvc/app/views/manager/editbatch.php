<!DOCTYPE html>
<html>

<head>
    <title>Edit batch</title>
    <?php include_once '../app/views/partials/head.php'; ?>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/stylesheet.css">
    <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>

</head>
<?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>

    <body>

        <div class="col-sm-10 col-sm offset-1">
            <h3 class="display-3">Edit batch</h3>
            <div class="editbatch-form-wrapper">
                <form method="POST" id="editform">
                    <div class="form-group">


                        <hr>
                        <h3 class="display-6">You are currently editing</h3>
                        <label for="batchID" id="batchID-label">batch ID: </label>
                        <input type="text" name="batchID" id="batchID" class="form-control" placeholder="" value="<?php echo $viewbag['batch'][0]['batchid'] ?>" readonly>
                        <br>
                        <hr>

                        <!-- <label for="productID" id="productid-label">Product ID: </label>
                <input type="text" name="productID" id="productID" value="<?php echo $viewbag['batch'][0]['productid'] ?>">
                <br> -->
                        <div class="form-group">
                            <label for="productID"> Choose product type: </label><br>
                            <select name="productID" id="productID" class="select-css" data-live-search="true">

                                <?php foreach ($viewbag['products'] as $prod) { ?>
                                    <option value="<?php echo $prod['productid']; ?> ">
                                        <?php echo $prod['productname']; ?>
                                    </option>
                                <?php } ?>
                            </select><br>
                        </div>

                        <div class="form-group">
                            <label for="productAmount" id="productAmount-label">Product amount: </label>
                            <input type="number" name="productAmount" id="productAmount" class="form-control" value="<?php echo $viewbag['batch'][0]['productamount'] ?>">
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="deadline" id="deadline-label">Deadline: </label>
                            <input type="date" name="deadline" id="deadline" class="form-control" value="<?php echo $viewbag['batch'][0]['deadline'] ?>">
                            <br>
                        </div>
                        <div class="form-group">
                            <label for="speed" id="speed-label">Speed: </label>
                            <input type="number" name="speed" id="speed" class="form-control" value="<?php echo $viewbag['batch'][0]['speed'] ?>">
                            <br>
                        </div>
                        <div class="form-group">

                            <hr>
                            <span id="editstatus"></span>
                        </div>
                    </div>
                    <input type="submit" class="editbutton" name="editbutton" value="Edit" onclick="submitEditBatch()"></input>
                    <input type="button" class="canceleditbuttoneditbatch" name="canceleditbuttoneditbatch" value="Cancel"></input>
                </form>

            </div>
        </div>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>