<!DOCTYPE html>
<html>

<head>
    <title> CalculateOEE </title>
</head>

<body>

    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
    <div>
        <br>
        OEE
        </br>
        <form method="POST" action="/brewsoft/mvc/public/manager/displayOeeForDay">
            <label for="dateofcompletion"> Pick a date: </label><br>
            <input type="date" id="dateofcompletion" name="dateofcompletion"><br>

            <input type="submit" name="showOee" id="showOee" value="pick" />
        </form>

        <div>
            <p for="OEE"> <?php if (!empty($viewbag['oeeResult'])) {
                                echo $viewbag['oeeResult'] . '&#37';
                            } ?> </p><br>
        </div>

    </div>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>