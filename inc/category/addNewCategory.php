<b>Add new category</b>:
<form action="category.php" method="post">
  Category name:
  <input type="text" name="categoryName"><br>
  Category color:
  <input type="color" name="categoryColor"><br>
  <input type="submit" value="Submit">
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