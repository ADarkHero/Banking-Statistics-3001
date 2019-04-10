<div id="accordion"> 
    
<?php

/********************
Categories
********************/

$contracts = array();

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $i = 0;
    while($row = $result->fetch_assoc()) {
        ?>
        <div class="card">
            <div class="card-header" id="heading<?php echo $i; ?>">
              <h5 class="mb-0">
                <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                    <div class="container">
                      <div class="row" >
                          <div class="col-12 col-lg-10 cut col-lg-l-align"><span style='color:<?php echo $row["CategoryColor"]; ?>'><?php echo $row["CategoryName"]; ?></span></div>   
                          <div class="col-12 col-lg-2"><span style='color:<?php echo $row["CategoryColor"]; ?>'><?php echo $row["CategoryColor"]; ?></span></div> 
                      </div>    
                    </div>         
                </button>
              </h5>
            </div>

            <div id="collapse<?php echo $i; ?>" class="collapse" aria-lebelledby="heading<?php echo $i; ?>" data-parent="#accordion">
              <div class="card-body">
                    <form action="category.php" method="POST">
                        <div class="form-group row">
                            <label for="categoryChangeName" class="col-3 col-form-label">Category name</label>
                            <div class="col-9"><input type="text" class="form-control" name="categoryChangeName" value="<?php echo $row["CategoryName"]; ?>"></div>
                        </div>
                        <div class="form-group row">
                            <label for="categoryChangeColor" class="col-3 col-form-label">Category color</label>
                            <div class="col-9"><input type="text" id="hue-demo" class="form-control demo" data-control="hue" name="categoryChangeColor" value="<?php echo $row["CategoryColor"]; ?>"></div> 
                        </div>
                        <div class="form-group row">
                            <label for="categoryChangeExcludeStats" class="col-3 col-form-label">Exclude from statistics</label>
                            <div class="col-9"><input type="checkbox" class="form-control" name="categoryChangeExcludeStats" <?php if($row["CategoryExcludeStats"] == 1){ echo "checked"; } ?>></div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="categoryChangeNameOld" value="<?php echo $row["CategoryName"]; ?>">
                            <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Change settings"></div>
                        </div>
                    </form>
              </div>
            </div>
          </div>
        <?php
        $i++;
    }
} else {
    echo "Error while fetching your categories. Do you have any?";
}
?>
    
</div>