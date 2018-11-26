<?php
	
	if(isSet($_POST["deleteContract"])){
		$sql = "DELETE FROM contracts WHERE ContractName = '".$_POST["deleteContract"]."'"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>The contract \"".$_POST["deleteContract"]."\" was deleted.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while deleting the contract from the database.</p>";
		}
		
		echo "<br>";
	}

?>

<b>Delete contract</b>:
<form action="index.php" method="post">
  Contract name:
  <input type="text" name="deleteContract">
  <input type="submit" value="Submit">
</form>