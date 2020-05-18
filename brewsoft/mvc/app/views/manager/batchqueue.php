<!DOCTYPE html>
<html>

<head>
    <title>batch queue</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/batchqueue.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
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
    <script src="../js/batch.js"></script>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>