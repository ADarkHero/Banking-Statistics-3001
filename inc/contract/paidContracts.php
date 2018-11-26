<?php

/********************
Contracts
********************/

$contracts = array();

$sql = "SELECT * FROM contracts";
$result = $conn->query($sql);

$moneySpent = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$contracts[$row["ContractName"]]=$row["ContractValue"];
    }
} else {
    echo "Error while fetching your last paycheck.";
}



/********************
Which contracts did we pay?
********************/
$sql = "SELECT Value, PaymtPurpose FROM statements WHERE EntryDate > '".$lastPaycheckDate."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
	$unpaidContracts = $contracts;
    while($row = $result->fetch_assoc()) {
		$purpose = $row["PaymtPurpose"];
		$purpose = str_replace("|","",$purpose); //Removes | from the transactions to make it better readable (and copieable) for humans; You can copy the transaction string from the Volksbank-backend now
		$in_array_r = in_array_return($purpose, $unpaidContracts);
		if ($in_array_r) {
			echo "You already <b class='contractPaid'>paid</b> your contract \"<b class='contractPaid'>".$in_array_r."</b>\"!<br>";
			unset($unpaidContracts[$in_array_r]); //Remove the value from the unpaid contract array
		}
    }
} else {
    echo "Error while fetching your contracts.";
}

foreach ($unpaidContracts as $key => $value){
	echo "You <b class='contractUnpaid'>didn't pay</b> your contract \"<b class='contractUnpaid'>".$key."</b>\" yet!<br>";
}


//Checks, if the string is in an array and returns the arraykey
function in_array_return($needle, $haystack) {
    foreach ($haystack as $key => $item) {
        if (strpos($needle, $item) !== false) {
			return $key;
		}  
    }
    return false;
}
