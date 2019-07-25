<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse9999" aria-expanded="false" aria-controls="collapse9999">
            <div class="container">
              <div class="row" >
                  <div class="col-12"><span class="text-primary">ADD NEW CONTRACT</span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>

    <div id="collapse9999" class="collapse" aria-lebelledby="heading9999" data-parent="#accordion">
      <div class="card-body">
        <form action="contract.php" method="post">
            <div class="form-group row">
                <label for="contractName" class="col-3 col-form-label">Contract name</label>
                <div class="col-9"><input type="text" class="form-control" name="contractName"  placeholder="The name of the contract you want to add"></div>
            </div>
            <div class="form-group row">
                <label for="contractValue" class="col-3 col-form-label">Payment purpose</label>
                <div class="col-9"><input type="text" class="form-control" name="contractValue" placeholder="Unique statement of the contract"></div>
            </div>
            <div class="form-group row">
                <label for="contractNote" class="col-3 col-form-label">Contract note</label>
                <div class="col-9"><input type="text" class="form-control" name="contractNote" placeholder="You can add a little note here."></div>
            </div>
            <div class="form-group row">
                <label for="contractAmount" class="col-3 col-form-label">Contract cost</label>
                <div class="col-9"><input type="number" step="0.01" class="form-control" name="contractAmount" placeholder="The monthly amount, you pay for your contract"></div>
            </div>
            <div class="form-group row">
                <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
            </div>
        </form>
      </div>
    </div>
  </div>


<?php
	
	if(isSet($_POST["contractName"]) & isSet($_POST["contractValue"]) & isSet($_POST["contractAmount"])){
            $sql = "INSERT INTO contracts VALUES ('".htmlspecialchars($_POST["contractName"])."', "
                    . "'".htmlspecialchars($_POST["contractValue"])."', "
                    . "'".htmlspecialchars($_POST["contractNote"])."', "
                    . "".htmlspecialchars($_POST["contractAmount"]).")"; //SQL statement
            
            if ($conn->query($sql) === TRUE) {
                    echo "<p class='successMessage'>Your new contract \"".htmlspecialchars($_POST["contractName"])."\" was added.</p>";
            } 
            else{
                    echo "<p class='errorMessage'>Error while writing the contract to the database.</p>";
            }

            echo "<br>";
	}

?>