<!DOCTYPE html>
<header>
    <title> Create batch </title>
    <link rel="stylesheet" href="../css/planbatch.css">
</header>

<body>
    <br>
    Please enter the correct values!
    </br>
    <form method="POST" action="indsæt sti her">
        <label for="productID"> Product id: </label><br>
        <select id="products">
        <option value="Pilsner">Pilsner</option>
        <option value="Wheat">Wheat</option>
        <option value="IPA">IPA</option>
        <option value="Stout">Stout</option>
        <option value="Ale">Ale</option>
        <option value="Alcohol free">Alcohol free</option>    
        </select> <br>
        
        <label for="productAmount"> Amount to produce: </label><br>
        <input type="text" id="productAmount" name="productAmount"><br>
        
        <label for="deadline"> Deadline: </label><br>
        <input type="date" id="deadline" name="deadline"><br>
    
        <label for="speed"> Speed: </label><br>
        <input type="text" id="speed" name="speed"><br>
        
        <input type="submit" name="planbatch" id="planbatch" value="Create"/>
    </form>
</body>