<!DOCTYPE html>
<html>

<head>
    <title>batch queue</title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/batchqueue.css">
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <div id="batch-table-wrapper">
            <div id="tableplace">
                <input type="text" class="search" name="search" id="search" placeholder="search for batches" onload="getQueuedBatches(this.value);" onkeyup="getQueuedBatches(this.value);">
                <div id="formobilescreen">
                    <input type="button" name="editbatch" class="editbatch" value="edit batch" />
                </div>
                <div id='tablewrap'>
                    <table id="table" class="table">
                        <thead id="tableheadid" class="thead-dark">
                            <tr>
                                <th scope="col">Productionlist ID</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Product ID</th>
                                <th scope="col">Product amount</th>
                                <th scope="col">Deadline</th>
                                <th scope="col">Speed</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date of creation</th>
                            </tr>
                        </thead>

                        <tbody id="queuedBatchData"></tbody>

                    </table>
                </div>
            </div>

            <input type="button" name="editbatch" class="editbatch" value="edit batch" />
           
        </div>
        <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>

    <?php include '../app/views/partials/foot.php'; ?>
