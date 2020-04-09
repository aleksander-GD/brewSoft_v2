<!DOCTYPE html>

<header>
    <title>Completed batches</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/batchqueue.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<!--     <script src="../js/batch.js"></script> -->
    <html lang="en">

</header>

<body>


    <div id="batch-table-wrapper">
        <div id="tableplace">
            <table id="table">
                <tr>
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
                <?php
                foreach ($viewbag['batches'] as $batch) {
                ?>
                    <tr>
                        <td><?= $batch['batchid'] ?> </td>
                        <td><?= $batch['brewerymachineid'] ?></td>
                        <td><?= $batch['deadline'] ?></td>
                        <td><?= $batch['dateofcreation'] ?></td>
                        <td><?= $batch['dateofcompletion'] ?></td>
                        <td><?= $batch['productid'] ?></td>
                        <td><?= $batch['totalcount'] ?></td>
                        <td><?= $batch['defectcount'] ?></td>
                        <td><?= $batch['acceptedcount'] ?></td>

                    </tr>

                <?php } ?>

            </table>
        </div>
        <!-- Instead insert button that redirects to batch report dashboard -->
        <!-- <input type="button" name="editbatch" class="editbatch" value="edit batch" /> -->
    </div>

</body>



</html>