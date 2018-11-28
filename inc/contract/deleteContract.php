<b>Delete contract</b>:

<form action="contract.php" method="post">
    <div class="form-group row">
        <label for="deleteContract" class="col-3 col-form-label">Contract name</label>
        <div class="col-9"><input type="text" class="form-control" name="deleteContract" placeholder="The name of the contract you want to delete"></div>
    </div>
    <div class="form-group row">
        <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
    </div>
</form>

<?php
	
	if(isSet($_POST["deleteContract"])){
		$sql = "DELETE FROM contracts WHERE ContractName = '".htmlspecialchars($_POST["deleteContract"])."'"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>The contract \"".htmlspecialchars($_POST["deleteContract"])."\" was deleted.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while deleting the contract from the database.</p>";
		}
		
		echo "<br>";
	}

?>