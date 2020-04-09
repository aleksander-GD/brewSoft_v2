<!DOCTYPE html>
<header>
    <title> Create batch </title>
    <link rel="stylesheet" href="../css/planbatch.css">
</header>

<body>
    <div>
    <br>
    Please enter the correct values!
    </br>
    <form method="POST" action="/brewsoft/mvc/public/manager/planbatch">
        <select name="products" id="products">
        <option value="0">Pilsner</option>
        <option value="1">Wheat</option>
        <option value="2">IPA</option>
        <option value="3">Stout</option>
        <option value="4">Ale</option>
        <option value="5">Alcohol free</option>    
        </select> <br>
        
        <label for="productAmount"> Amount to produce: </label><br>
        <input type="text" id="productAmount" name="productAmount"><br>
        
        <label for="deadline"> Deadline: </label><br>
        <input type="date" id="deadline" name="deadline"><br>
    
        <label for="speed"> Speed: </label><br>
        <input type="text" id="speed" name="speed"><br>
        
        <input type="submit" name="planbatch" id="planbatch" value="Create"/>
    </form>
</div>

</body>
</html>