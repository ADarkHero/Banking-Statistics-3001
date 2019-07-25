<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse99999" aria-expanded="false" aria-controls="collapse99999">
            <div class="container">
              <div class="row" >
                  <div class="col-12"><span class="text-danger">DELETE CONTRACT</span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>

    <div id="collapse99999" class="collapse" aria-lebelledby="heading99999" data-parent="#accordion">
      <div class="card-body">
            <form action="contract.php" method="post">
            <div class="form-group row">
                <label for="deleteContract" class="col-3 col-form-label">Contract name</label>
                <div class="col-9"><input type="text" class="form-control" name="deleteContract" placeholder="The name of the contract you want to delete"></div>
            </div>
            <div class="form-group row">
                <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
            </div>
        </form>
      </div>
    </div>
  </div>



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