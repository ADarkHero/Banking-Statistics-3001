<b>Delete category</b>:

<form action="category.php" method="post">
    <div class="form-group row">
        <label for="deleteCategory" class="col-3 col-form-label">Category name</label>
        <div class="col-9"><input type="text" class="form-control" name="deleteCategory"  placeholder="The name of the category you want to delete"></div>
    </div>
    <div class="form-group row">
        <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
    </div>
</form>

<?php
	
	if(isSet($_POST["deleteCategory"])){
		$sql = "DELETE FROM categories WHERE CategoryName = '".$_POST["deleteCategory"]."'"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>The category \"".$_POST["deleteCategory"]."\" was deleted.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while deleting the category from the database.</p>";
		}
		
		echo "<br>";
	}

?>