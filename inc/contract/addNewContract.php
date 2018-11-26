<b>Add new contract</b>:
<form action="contract.php" method="post">
  Contract name:
  <input type="text" name="contractName"><br>
  Payment purpose:
  <input type="text" name="contractValue"><br>
  <input type="submit" value="Submit">
</form>

<?php
	
	if(isSet($_POST["contractName"]) & isSet($_POST["contractValue"])){
            $sql = "INSERT INTO contracts VALUES ('".$_POST["contractName"]."', '".$_POST["contractValue"]."')"; //SQL statement

            if ($conn->query($sql) === TRUE) {
                    echo "<p class='successMessage'>Your new contract \"".$_POST["contractName"]."\" was added.</p>";
            } 
            else{
                    echo "<p class='errorMessage'>Error while writing the contract to the database.</p>";
            }

            echo "<br>";
	}

?>