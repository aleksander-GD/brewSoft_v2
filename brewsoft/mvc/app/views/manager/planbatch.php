<!DOCTYPE html>
<html>

<head>
    <title> Create batch </title>
    <link rel="stylesheet" href="../css/planbatch.css">
</head>

<body>

    <?php include_once '../app/views/partials/menu.php'; ?>
    <div>
        <br>
        Please enter the correct values!
        </br>
        <form method="POST" action="/brewsoft/mvc/public/manager/planBatch">
            <label for="producttype"> Choose product type: </label><br>


            <?php if (!empty($viewbag['products']) || $viewbag['products'] != null) { ?>
                <select name="products" id="products">
                    <?php
                    foreach ($viewbag['products'] as $prod) { ?>
                        <option value="<?php echo $prod['productid']; ?>"><?php echo $prod['productname'];     ?></option>
                    <?php }
                } else { ?>
                    <input type="text" id="products" name="products"><br>
                <?php } ?>


                </select><br>

                <label for="productAmount"> Amount to produce: </label><br>
                <input type="text" id="productAmount" name="productAmount"><br>

                <label for="deadline"> Deadline: </label><br>
                <input type="date" id="deadline" name="deadline"><br>

                <label for="speed"> Speed: </label><br>
                <input type="text" id="speed" name="speed"><br>

                <input type="submit" name="planbatch" id="planbatch" value="Create" />
        </form>
    </div>

    <?php include '../app/views/partials/foot.php'; ?>