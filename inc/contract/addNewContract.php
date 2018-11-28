<b>Add new contract</b>:

<form action="contract.php" method="post">
    <div class="form-group row">
        <label for="contractName" class="col-3 col-form-label">Contract name</label>
        <div class="col-9"><input type="text" class="form-control" name="contractName"></div>
    </div>
    <div class="form-group row">
        <label for="contractValue" class="col-3 col-form-label">Payment purpose</label>
        <div class="col-9"><input type="text" class="form-control" name="contractValue"></div>
    </div>
    <div class="form-group row">
        <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
    </div>
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