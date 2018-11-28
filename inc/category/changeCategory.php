<b>Change category</b>:

<form action="category.php" method="post">
    <div class="form-group row">
        <label for="categoryChangeName" class="col-3 col-form-label">Category name</label>
        <div class="col-9"><input type="text" class="form-control" name="categoryChangeName" placeholder="The name of the category you want to change"></div>
    </div>
    <div class="form-group row">
        <label for="categoryChangeName" class="col-3 col-form-label">NEW Category name</label>
        <div class="col-9"><input type="text" class="form-control" name="categoryChangeNewName" placeholder="Leave blank, if you don't want to change it"></div>
    </div>
    <div class="form-group row">
        <label for="categoryChangeColor" class="col-3 col-form-label">Category color</label>
        <div class="col-9"><input type="text" id="hue-demo" class="form-control demo" data-control="hue" name="categoryChangeColor" value="#000000"></div>
    </div>
    <div class="form-group row">
        <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
    </div>
</form>

<?php
	
    if(isSet($_POST["categoryChangeName"]) && isSet($_POST["categoryChangeColor"])){
        $sql = "UPDATE categories SET  ";
        if($_POST["categoryChangeNewName"]){
            $sql .= "CategoryName = '".htmlspecialchars($_POST["categoryChangeNewName"])."', ";
        }
        $sql .= "CategoryColor = '".htmlspecialchars($_POST["categoryChangeColor"])."' WHERE CategoryName = '".htmlspecialchars($_POST["categoryChangeName"])."'"; //SQL statement

        if ($conn->query($sql) === TRUE) {
                echo "<p class='successMessage'>The category \"".htmlspecialchars($_POST["categoryChangeName"])."\" was edited.</p>";
        } 
        else{
                echo "<p class='errorMessage'>Error while editing the category from the database.</p>";
        }

        echo "<br>";
    }

?>