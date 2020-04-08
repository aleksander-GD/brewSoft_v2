<!DOCTYPE html>

<header>
    <title>batchqueue</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/batchqueue.css">
    <script type='text/javascript' src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="../js/batch.js"></script>
    <html lang="en">

</header>

<body>


    <div id="batch-table-wrapper">
        <div id="tableplace">
            <table id="table">
                <tr>
                    <th>Batch ID</th>
                    <th>Product ID</th>
                    <th>Product amount</th>
                    <th>Deadline</th>
                    <th>Speed</th>
                    <th>Status</th>
                    <th>Date of creation</th>
                </tr>
                <?php
                foreach ($viewbag['batches'] as $batch) {
                ?>
                    <tr>
                        <td><?= $batch['batchid'] ?></td>
                        <td><?= $batch['productid'] ?></td>
                        <td><?= $batch['productamount'] ?></td>
                        <td><?= $batch['deadline'] ?></td>
                        <td><?= $batch['speed'] ?></td>
                        <td><?= $batch['status'] ?></td>
                        <td><?= $batch['dateofcreation'] ?></td>

                    </tr>

                <?php } ?>

            </table>
        </div>
        <input type="button" name="editbatch" class="editbatch" value="edit batch" />
    </div>

</body>



</html>