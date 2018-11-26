<?php
	
	if(isSet($_POST["categoryName"])){
		$sql = "INSERT INTO categories VALUES ('".$_POST["categoryName"]."')"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>Your new category \"".$_POST["categoryName"]."\" was added.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while writing the category to the database.</p>";
		}
		
		echo "<br>";
	}

?>

<b>Add new category</b>:
<form action="index.php" method="post">
  Category name:
  <input type="text" name="categoryName">
  <input type="submit" value="Submit">
</form>