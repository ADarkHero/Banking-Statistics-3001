<?php
/********************
DEPENDS ON
 * inc/index/lastPaycheck.php
********************/



/********************
Contracts
********************/

$contracts = array();
$contractAmounts = array();
$contractNotes = array();

$sql = "SELECT * FROM contracts";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$contracts[$row["ContractName"]] = $row["ContractValue"];
        $contractAmounts[$row["ContractName"]] = $row["ContractAmount"];
        $contractNotes[$row["ContractName"]] = $row["ContractNote"];
    }
} else {
    echo "Error while fetching your last paycheck.";
}


/********************
Which contracts did we pay?
********************/
$sql = "SELECT PaymtPurpose FROM statements WHERE EntryDate >= '".$lastPaycheckDate."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $unpaidContracts = $contracts;
    $paidContracts = array();
    while($row = $result->fetch_assoc()) {
        $purpose = str_replace("|", "", $row["PaymtPurpose"]); //Removes | from the transactions to make it better readable (and copieable) for humans; You can copy the transaction string from the Volksbank-backend now
        $in_array_r = in_array_return($purpose, $unpaidContracts);
        
        //If the contract was paid, remove it from the unpaid-array and add it to the paid array.
        while ($in_array_r) { 
            $paidContracts[$in_array_r] = $unpaidContracts[$in_array_r];
            unset($unpaidContracts[$in_array_r]); //Remove the value from the unpaid contract array
            $in_array_r = in_array_return($purpose, $unpaidContracts); //Fix, if more than one contract has the same ContractValue; Now removes all of them
        }
    }
} else {
    echo "Error while fetching your contracts.";
}

$contractCosts = 0;
foreach ($unpaidContracts as $key => $value){
    $contractCosts += $contractAmounts[$key];
}


//Checks, if the string is in an array and returns the arraykey
function in_array_return($haystack, $needle) {
    foreach ($needle as $key => $item) {
        if (strpos($haystack, $item) !== false) {
            return $key;
        }  
    }
    return false;
}
