<!DOCTYPE html>
<html>

<head>
    <title> CalculateOEE </title>
    <?php include_once '../app/views/partials/head.php'; ?>
</head>

<body>

    <?php include_once '../app/views/partials/menu.php'; ?>
    <?php if (isset($_SESSION['usertype']) && ($_SESSION['usertype'] == 'Manager' || $_SESSION['usertype'] == 'Admin')) : ?>
        <div>
            <div class="col-sm-10 col-sm offset-1">
                <h3 class="display-3">Display OEE for a day</h3>
                <form method="POST" action="/brewsoft/mvc/public/manager/displayOeeForDay">
                    <div class="form-group">
                        <label for="dateofcompletion"> Pick a date: </label><br>
                        <input type="date" id="dateofcompletion" name="dateofcompletion" class="form-control"><br>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="showOee" id="showOee" value="pick" class="btn btn-primary" />
                    </div>
                </form>

                <div>
                    <p for="OEE"> <?php if (!empty($viewbag['oeeResult'])) {
                                        echo "<h3 class='display-6'>" .  $viewbag['oeeResult'] . '&#37' . "</h3>";
                                    } ?> </p><br>
                </div>

            </div>
        </div>
    <?php else : ?>
        <?php include_once '../app/views/brewworker/Dashboard.php'; ?>

    <?php endif; ?>
    <?php include '../app/views/partials/foot.php'; ?>