<!DOCTYPE html>
<html>

<head>
    <title> Create batch </title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/stylesheet.css">
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <div>
            <br>
            Please enter the correct values!
            </br>
            <form method="POST" action="/brewsoft/mvc/public/manager/planBatch">
                <div class="form-group">
                    <label for="producttype"> Choose product type: </label><br>

                    <?php if (!empty($viewbag['products']) || $viewbag['products'] != null) { ?>
                        <select name="products" id="products" class="select-css">
                            <?php
                            foreach ($viewbag['products'] as $prod) { ?>
                                <option value="<?php echo $prod['productid']; ?>"><?php echo $prod['productname'];     ?></option>
                            <?php }
                        } else { ?>
                            <input type="text" id="products" name="products"><br>
                        <?php } ?>



                        </select><br>
                </div>
                <div class="form-group">
                    <label for="productAmount"> Amount to produce: </label><br>
                    <input type="text" id="productAmount" class="form-control" name="productAmount"><br>
                </div>
                <div class="form-group">
                    <label for="deadline"> Deadline: </label><br>
                    <input type="date" id="deadline" class="form-control" name="deadline"><br>
                </div>
                <div class="form-group">
                    <label for="speed"> Speed: </label><br>
                    <input type="text" id="speed" class="form-control" name="speed"><br>
                </div>
                <input type="submit" name="planbatch" class="btn btn-primary" id="planbatch" value="Create" />
            </form>
        </div>

    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>

    <?php include '../app/views/partials/foot.php'; ?>