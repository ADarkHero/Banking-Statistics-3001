<?php

$sql = "SELECT EntryDate, Value FROM statements WHERE AcctNo='".$payCheckAccount."' ORDER BY EntryDate DESC"; //SQL statement
$result = $conn->query($sql);


/********************
When did we get our last paycheck?
********************/
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $lastPaycheckDates[] = $row["EntryDate"];
        $lastPaycheckAmounts[] = $row["Value"];
    }
} else {
    echo "Error while fetching your last paycheck.";
}

//Sets current paycheck date/amount and the date for the next paycheck
//If there is no next paycheck, set it to today.
if(isset($_GET["paycheckDate"])){
    $customPaycheckDay = htmlspecialchars($_GET["paycheckDate"]);
}
else{
    $customPaycheckDay = 0;
}

$lastPaycheckDate = $lastPaycheckDates[$customPaycheckDay];
$lastPaycheckAmount = $lastPaycheckAmounts[$customPaycheckDay];
if($customPaycheckDay > 0){
    $nextPaycheckDate = $lastPaycheckDates[$customPaycheckDay-1];
}
else{
    $nextPaycheckDate = date("Y-m-d");
}

