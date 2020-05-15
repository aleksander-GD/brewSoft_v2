<!DOCTYPE html>
<html>

<head>
    <title> Create batch </title>
    <link rel="stylesheet" href="../css/planbatch.css">
</head>

<body>
    <div>
        <br>
        Please enter the correct values!
        </br>
        <form method="POST" action="/brewsoft/mvc/public/manager/planbatch">
            <label for="producttype"> Choose product type: </label><br>
            <select name="products" id="products">


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
    <?php else : ?>
    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>
