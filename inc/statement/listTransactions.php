<?php
$categories = getCategoryList($conn);

 if(isset($_POST["changeCategory"])){
     changeCategory($conn, htmlspecialchars($_POST["changeCategory"]), $_POST["paymtPurpose"]);
 }

if(isset($_GET["page"])){
    $currentpage = htmlspecialchars($_GET["page"]);
}
else{
    $currentpage = 1;
}
$offset = $pagesize * ($currentpage-1);

$sql = "SELECT EntryDate, AcctNo, BankCode, Name1, Name2, PaymtPurpose, Value, statements.CategoryID AS CategoryID, CategoryName, CategoryColor"
        . " FROM statements LEFT JOIN categories ON statements.CategoryID = categories.CategoryID ".$searchString;
$sql .= " ORDER BY EntryDate DESC LIMIT ". $pagesize ." OFFSET " . $offset;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div id="accordion">';
    
    // output data of each row
    $i = 0;
    while($row = $result->fetch_assoc()) {
           $purpose =  str_replace("|", "", $row["PaymtPurpose"]); //Remove the | in the string to make it better readable for humans.
           $purpose_text = $purpose;
           if (strpos($purpose, 'SVWZ+') !== false) {
                $purpose_text = strstr($purpose, 'SVWZ+', FALSE); //Remove everything before SVWZ+, to only get the transaction text
                $purpose_text = substr($purpose_text, 5);
            }     
?>
            <div class="card">
              <div class="card-header" id="heading<?php echo $i; ?>">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
                      <div class="container">
                        <div class="row" style="color: <?php echo $row["CategoryColor"]; ?>">
                            <div class="col-12 col-lg-2"><?php echo $row["EntryDate"]; ?></div>   
                            <div class="col-12 col-lg-8 cut"><?php echo $purpose_text; ?></div> 
                            <div class="col-12 col-lg-2 col-lg-r-align"><?php echo bankNumberFormatComma($row["Value"])." ".$currency; ?></div> 
                        </div>    
                      </div>         
                  </button>
                </h5>
              </div>

              <div id="collapse<?php echo $i; ?>" class="collapse" aria-lebelledby="heading<?php echo $i; ?>" data-parent="#accordion">
                <div class="card-body">
                    <table class="table">
                        <tbody>
                    
<?php
                    echo "<tr><td><b>Entry Date</b></td><td class='word-break'>".$row["EntryDate"]."</td></tr>";
                    echo "<tr><td><b>Account Number</b></td><td class='word-break'>".$row["AcctNo"]."</td></tr>";
                    echo "<tr><td><b>Bank Code</b></td><td class='word-break'>".$row["BankCode"]."</td></tr>";
                    echo "<tr><td><b>Name</b></td><td class='word-break'>".$row["Name1"]." ".$row["Name2"]."</td></tr>";
                    echo "<tr><td><b>Payment Purpose (Long)</b></td><td class='word-break'>".$purpose."</td></tr>";
                    echo "<tr><td><b>Payment Purpose</b></td><td class='word-break'>".$purpose_text."</td></tr>";
                    echo "<tr><td><b>Value</b></td><td class='word-break'>".bankNumberFormatComma($row["Value"])." ".$currency."</td></tr>"; 
                    categoryDropdown($categories, $row["CategoryID"], $row["CategoryName"], $row["CategoryColor"], $row["PaymtPurpose"]);                   
?>
                        </tbody>     
                    </table>
                </div>
              </div>
            </div>
<?php
    $i++;       
    }
    echo "</div>";
} else {
    echo "No entries found.";
}


//Generates a dropdown, so the user can choose a category
function categoryDropdown($categories, $categoryID, $categoryName, $categoryColor, $purpose){
    echo "<tr><td><b>Category</b></td><td class=''>";
?>
    <form action="statement.php?search=<?php if(isset($_GET["search"])){ echo htmlspecialchars($_GET["search"]); }?>&page=<?php if(isset($_GET["page"])){ echo htmlspecialchars($_GET["page"]); } else { echo "1"; } ?>" method="post">
        <div class="form-group row">
            <div class="col-10">
                <select name="changeCategory" class="form-control">
<?php
                foreach ($categories as $key => $value){
                    if($value == $categoryID){
                        //Set the current category as preselected
                        echo '<option value="'.$value.'" selected>'.$key.'</option>';
                    }
                    else{
                        echo '<option value="'.$value.'">'.$key.'</option>';
                    }

                }
?>
                </select>
            </div>
            <div class="col-2">
                <input type="hidden" name="paymtPurpose" value="<?php echo $purpose; ?>">
                <input type="submit" class="btn btn-primary form-control">
            </div>
        </div>
    </form>
 <?php           
    echo "</td></tr>";
}

//If the category was changed, write it into the database
function changeCategory($conn, $newCategory, $purpose){
    $sql = "UPDATE statements SET CategoryID='".$newCategory."' WHERE PaymtPurpose = '".$purpose."'"; //SQL statement
        
    if ($conn->query($sql) === TRUE) {
        echo "<p class='successMessage'>Your category was changed.</p>";
    } 
    else{
        echo "<p class='errorMessage'>Error while writing the new category to the database.</p>";
    }
}

//Returns all categories in an array
function getCategoryList($conn){
    $categories = array();

    $sql = "SELECT * FROM categories ORDER BY CategoryName";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
                    $categories[$row["CategoryName"]]=$row["CategoryID"];
        }
    } else {
        echo "Error while fetching your last paycheck.";
    }
    
    return $categories;
}

?>