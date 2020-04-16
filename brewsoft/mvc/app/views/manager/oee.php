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
        <label for="datepicker"> Pick a date: </label><br>
        <input type="date" id="datepicker" name="datepicker"><br>
        
        <input type="submit" name="showOee" id="showOee" value="pick"/>
    </form>

    <div>
    <p for="OEE"> <?php if (!empty($viewbag['oeeResult'])) {
  echo $viewbag['oeeResult'];
} ?> </p><br>
    </div>
    </div>

</body>
</html>