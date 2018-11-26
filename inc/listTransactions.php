<?php

$sql = "SELECT * FROM statements ORDER BY EntryDate DESC LIMIT 25";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    //Output headline
    echo "Entry Date | Account Number | Bank Code | Name | Payment Purpose | Value";
    echo "<br><br>";
    
    // output data of each row
    while($row = $result->fetch_assoc()) {
           $purpose =  str_replace("|","",$row["PaymtPurpose"]); //Remove the | in the string to make it better readable for humans.
        
            echo $row["EntryDate"]." | ".
                    $row["AcctNo"]." | ".
                    $row["BankCode"]." | ".
                    $row["Name1"]." ".
                    $row["Name2"]." | ".
                    $purpose." | ".
                    $row["Value"];
            echo "<br><br>";
    }
} else {
    echo "Error while fetching your last paycheck.";
}
