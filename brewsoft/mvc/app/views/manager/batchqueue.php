<!DOCTYPE html>
<html>

<head>
    <title>batch queue</title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/batchqueue.css">
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <div id="batch-table-wrapper">
        <div id="tableplace">
            <input type="text" class="search" name="search" id="search" placeholder="search for batches" onload="getQueuedBatches(this.value);" onkeyup="getQueuedBatches(this.value);">
            <table id="table">
                <thead>
                    <tr>
                        <th>Productionlist ID</th>
                        <th>Batch ID</th>
                        <th>Product ID</th>
                        <th>Product amount</th>
                        <th>Deadline</th>
                        <th>Speed</th>
                        <th>Status</th>
                        <th>Date of creation</th>
                    </tr>
                </thead>

                <tbody id="queuedBatchData"></tbody>

            </table>
        </div>
        <input type="button" name="editbatch" class="editbatch" value="edit batch" />
    </div>
    <script src="<?php echo DOC_ROOT; ?>/js/batch.js"></script>

    <?php include '../app/views/partials/foot.php'; ?>
