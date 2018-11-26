<b>Add new category</b>:
<form action="category.php" method="post">
    <div class="form-group row">
        <label for="categoryName" class="col-2 col-form-label">Category name</label>
        <div class="col-10"><input type="text" class="form-control" name="categoryName"></div>
    </div>
    <div class="form-group row">
        <label for="categoryName" class="col-2 col-form-label">Category name</label>
        <div class="col-10"><input type="color" class="form-control" name="categoryColor"></div>
    </div>
    <div class="form-group row">
        <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
    </div>
</form>

<?php
	
	if(isSet($_POST["categoryName"]) && isSet($_POST["categoryColor"])){
		$sql = "INSERT INTO categories VALUES (null, '".$_POST["categoryName"]."', '".$_POST["categoryColor"]."')"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>Your new category \"".$_POST["categoryName"]."\" was added.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while writing the category to the database.</p>";
		}
		
		echo "<br>";
	}

?>