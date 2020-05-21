<!DOCTYPE html>
<html>

<head>
    <title>Completed batches</title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/batchqueue.css">
    <?php include_once '../app/views/partials/head.php'; ?>
    <!--script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script-->
</head>

<body>

    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <div id="batch-table-wrapper">
            <div id="tableplace">
                <input type="text" class="search" name="search" id="search" placeholder="search for batches" onload="getCompletedBatches(this.value);" onkeyup="getCompletedBatches(this.value);">
                <div id="formobilescreen">
                    <input type="button" name="showOeeForBatch" id="showOeeForBatch" class="showOeeForBatch" value="Generate Batch report" />
                </div>

                <div id='tablewrap'>
                    <table id="table" class="table">
                        <thead id="tableheadid" class="thead-dark">
                            <tr>
                                <th scope="col">Productionlist ID</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Brewerymachine ID</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Date of creation</th>
                                <th scope="col">Date of completion</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">Total count</th>
                                <th scope="col">Defect count</th>
                                <th scope="col">Accepted count</th>
                            </tr>
                        </thead>

                        <tbody id="completedBatchData"></tbody>

                    </table>
                </div>
            </div>
            <input type="button" name="showOeeForBatch" id="showOeeForBatch" class="showOeeForBatch" value="Generate Batch report" />
            <!-- Instead insert button that redirects to batch report dashboard -->
            <!-- <input type="button" name="editbatch" class="editbatch" value="edit batch" /> -->
        </div>
        <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>

    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>
