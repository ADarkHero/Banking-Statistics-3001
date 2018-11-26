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

<b>Delete category</b>:
<form action="index.php" method="post">
  Category name:
  <input type="text" name="deleteCategory">
  <input type="submit" value="Submit">
</form>