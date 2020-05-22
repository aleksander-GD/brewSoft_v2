<!DOCTYPE html>
<html>

<head>
    <title> Create batch </title>
    <link rel="stylesheet" href="<?php echo DOC_ROOT; ?>/css/stylesheet.css">
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>
    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <div>
            <div class="col-sm-10 col-sm offset-1">
                <h3 class="display-3">Create a batch</h3>
                <form method="POST" action="/brewsoft/mvc/public/manager/planBatch">
                    <div class="form-group">
                        <label for="producttype"> Choose product type: </label><br>

                        <?php if (!empty($viewbag['products']) || $viewbag['products'] != null) { ?>
                            <select name="products" id="products" class="select-css">
                                <option></option>
                                <?php
                                foreach ($viewbag['products'] as $prod) { ?>
                                    <option value="<?php echo $prod['productid'];
                                                    $_POST['speed'] = $prod['speed'];  ?>"><?php echo $prod['productname'];
                                                                                            $_POST['productname'] = $prod['productname']; ?></option>
                                <?php }
                            } else { ?>
                                <input type="text" id="products" name="products"><br>
                            <?php } ?>



                            </select><br>
                    </div>
                    <div class="form-group">
                        <label for="productAmount"> Amount to produce: </label><br>
                        <input type="number" id="productAmount" class="form-control" name="productAmount"><br>
                    </div>
                    <div class="form-group">
                        <label for="deadline"> Deadline: </label><br>
                        <input type="date" id="deadline" class="form-control" name="deadline"><br>
                    </div>
                    <div class="form-group">
                        <label for="speed"> Speed: </label><br>

                        <input type="number" id="speed" class="form-control" name="speed" disabled="disabled"><br>
                        <div class="btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-dark active">
                                <input type="checkbox" id="speedcheckbox" checked> Change speed
                            </label>
                        </div>
                    </div>
                    <input type="submit" name="planbatch" class="btn btn-primary" id="planbatch" value="Create" />
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                var productname;

                var productsArray = [
                    <?php
                    $productsArray = "";
                    foreach ($viewbag['products'] as $prod) :
                        $productsArray .= "['" . $prod['productname'] . "', " . $prod['speed'] . "], \n \t\t\t\t";
                    endforeach;

                    echo substr($productsArray, 0, strrpos($productsArray, ','));


                    ?>
                ];

                var speed;
                console.log(productsArray);
                $("select").change(function() {
                    productname = $.trim($("#products").children("option:selected").text());
                    var temp;
                    for (i = 0; i < productsArray.length; i++) {
                        temparray = productsArray[i];
                        for (j = 0; j < temparray.length; j++) {
                            if (temparray[j] === productname) {
                                speed = temparray[j + 1];
                            }
                        }
                    }
                    $('#speed').val(speed);
                });

                $('#speedcheckbox').click(function() {
                    $('#speed').attr('disabled', !(this.checked))
                });
            });
        </script>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>

    <?php include '../app/views/partials/foot.php'; ?>