<div class="col-12"><h2 class="mt-3">Variables</h2></div>

<div id="accordion"> 
    
<?php

/********************
Categories
********************/

$contracts = array();

$sql = "SELECT * FROM settings";
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
                          <div class="col-12 col-lg-6 cut col-lg-l-align"><span><?php echo $row["SettingName"]; ?></span></div>   
                          <div class="col-12 col-lg-6 col-lg-r-align"><span><?php echo $row["SettingValue"]; ?></span></div> 
                      </div>    
                    </div>         
                </button>
              </h5>
            </div>

            <div id="collapse<?php echo $i; ?>" class="collapse" aria-lebelledby="heading<?php echo $i; ?>" data-parent="#accordion">
              <div class="card-body">
                    <form action="settings.php" method="POST">
                        <div class="form-group row">
                            <label for="settingsChangeID" class="col-3 col-form-label">Settings ID</label>
                            <div class="col-9"><input type="text" class="form-control" name="settingsChangeID" disabled value="<?php echo $row["SettingID"]; ?>"></div>
                        </div>
                        <div class="form-group row">
                            <label for="settingsChangeName" class="col-3 col-form-label">Settings name</label>
                            <div class="col-9"><input type="text" class="form-control" name="settingsChangeName" value="<?php echo $row["SettingName"]; ?>"></div>
                        </div>
                        <div class="form-group row">
                            <label for="settingsChangeValue" class="col-3 col-form-label">Settings value</label>
                            <div class="col-9"><input type="text" class="form-control" name="settingsChangeValue" value="<?php echo $row["SettingValue"]; ?>"></div> 
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="settingsChangeID" value="<?php echo $row["SettingID"]; ?>">
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
    echo "Error while fetching settings.";
}
?>
    
</div>