<!DOCTYPE html>
<html>

<head>
    <title>Completed batches</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/batchqueue.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="../js/batch.js"></script>

</head>

<body>
    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
        <?php include_once '../app/views/partials/menu.php'; ?>

        <div id="batch-table-wrapper">
            <div id="tableplace">
                <input type="text" class="search" name="search" id="search" placeholder="search for batches" onload="getCompletedBatches(this.value);" onkeyup="getCompletedBatches(this.value);">
                <table id="table">
                    <thead>
                        <tr>
                            <th>Productionlist ID</th>
                            <th>Batch ID</th>
                            <th>Brewerymachine ID</th>
                            <th>Deadline</th>
                            <th>Date of creation</th>
                            <th>Date of completion</th>
                            <th>Product ID</th>
                            <th>Total count</th>
                            <th>Defect count</th>
                            <th>Accepted count</th>
                        </tr>
                    </thead>

                    <tbody id="completedBatchData"></tbody>

                </table>
            </div>
            <input type="button" name="generateBatchReport" class="generateBatchReport" value="Generate Batch report" />
            <!-- Instead insert button that redirects to batch report dashboard -->
            <!-- <input type="button" name="editbatch" class="editbatch" value="edit batch" /> -->
        </div>
        
    <?php else : ?>
    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>