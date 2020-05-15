<!DOCTYPE html>
<html>

<head>
    <title> CalculateOEE </title>
</head>

<body>
    <div>
        <br>
        OEE
        </br>
        <form method="POST" action="/brewsoft/mvc/public/manager/displayOeeForDay">
            <label for="dateofcompletion"> Pick a date: </label><br>
            <input type="date" id="dateofcompletion" name="dateofcompletion"><br>

            <div>
                <p for="OEE"> <?php if (!empty($viewbag['oeeResult'])) {
                                    echo $viewbag['oeeResult'] . '&#37';
                                } ?> </p><br>
            </div>

        </div>
    <?php else : ?>
    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>

