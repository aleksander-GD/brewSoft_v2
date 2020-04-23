<!DOCTYPE html>
<header>
    <title> CalculateOEE </title>
</header>

<body>
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

</body>

</html>