<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse9999" aria-expanded="false" aria-controls="collapse9999">
            <div class="container">
              <div class="row" >
                  <div class="col-12"><span class="text-primary">ADD NEW CATEGORY</span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>

    <div id="collapse9999" class="collapse" aria-lebelledby="heading9999" data-parent="#accordion">
      <div class="card-body">
        <form action="category.php" method="post">
            <div class="form-group row">
                <label for="categoryName" class="col-3 col-form-label">Category name</label>
                <div class="col-9"><input type="text" class="form-control" name="categoryName" placeholder="The name of the category you want to add"></div>
            </div>
            <div class="form-group row">
                <label for="categoryName" class="col-3 col-form-label">Category color</label>
                <div class="col-9"><input type="text" id="hue-demo" class="form-control demo" data-control="hue" name="categoryColor" value="#000000"></div> 
            </div>
            <div class="form-group row">
                <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Submit"></div>
            </div>
        </form>
      </div>
    </div>
  </div>





<?php
	
	if(isSet($_POST["categoryName"]) && isSet($_POST["categoryColor"])){
		$sql = "INSERT INTO categories VALUES (null, '".htmlspecialchars($_POST["categoryName"])."', '".htmlspecialchars($_POST["categoryColor"])."')"; //SQL statement
				
		if ($conn->query($sql) === TRUE) {
			echo "<p class='successMessage'>Your new category \"".htmlspecialchars($_POST["categoryName"])."\" was added.</p>";
		} 
		else{
			echo "<p class='errorMessage'>Error while writing the category to the database.</p>";
		}
		
		echo "<br>";
	}

?>

