<?php
if(isset($_GET["page"])){
    $currentpage = $_GET["page"];
}
else{
    $currentpage = 1;
}
$offset = $pagesize * ($currentpage-1);

$sql = "SELECT EntryDate, AcctNo, BankCode, Name1, Name2, PaymtPurpose, Value"
        . " FROM statements ORDER BY EntryDate DESC LIMIT ". $pagesize ." OFFSET " . $offset;
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
                        <div class="row">
                            <div class="col-2"><?php echo $row["EntryDate"]; ?></div>   
                            <div class="col-8 cut"><?php echo $purpose_text; ?></div> 
                            <div class="col-2 r-align"><?php echo $row["Value"]; ?> €</div> 
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
                    echo "<tr><td><b>Value</b></td><td class='word-break'>".$row["Value"]." €</td></tr>";                    
                    echo "<tr><td><b>Category</b></td><td class='word-break'>";
                    echo "//TODO";
                    echo "</td></tr>";                    
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
    echo "Error while fetching your last paycheck.";
}
?>