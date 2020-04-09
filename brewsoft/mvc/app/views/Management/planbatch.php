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
        <label for="productid"> Product id: </label><br>
        <select id="products">
        <option value="Pilsner">Pilsner</option>
        <option value="Wheat">Wheat</option>
        <option value="IPA">IPA</option>
        <option value="Stout">Stout</option>
        <option value="Ale">Ale</option>
        <option value="Alcohol free">Alcohol free</option>    
        </select> <br>
        
        <label for="productamount"> Amount: </label><br>
        <input type="text" id="productamount" name="productamount"><br>
        
        <label for="deadline"> Deadline: </label><br>
        <input type="date" id="deadline" name="deadline"><br>
    
        <label for="speed"> Speed: </label><br>
        <input type="text" id="speed" name="speed"><br>
        
        <input type="submit" value="Create"/>
    </form>
</body>