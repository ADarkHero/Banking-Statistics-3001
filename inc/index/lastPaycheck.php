<?php
$sql = "SELECT MAX(EntryDate) AS MaxDate, Value FROM statements WHERE AcctNo='".$payCheckAccount."'"; //SQL statement
$result = $conn->query($sql);


/********************
When did we get our last paycheck?
********************/
$lastPaycheckDate = "";
$lastPaycheckAmount = "";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$lastPaycheckDate = $row["MaxDate"];
		$lastPaycheckAmount = $row["Value"];
    }
} else {
    echo "Error while fetching your last paycheck.";
}
