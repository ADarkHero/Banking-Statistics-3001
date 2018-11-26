<?php
require_once('lastPaycheck.php');
echo "You got your last paycheck on <b class='lastPaycheckDate'>" . $lastPaycheckDate . "</b>! It were <b class='lastPaycheckAmount'>" . $lastPaycheckAmount . " €</b>!<br>";

/********************
How much money did we spent since then?
********************/
$sql = "SELECT Value FROM statements WHERE EntryDate > '".$lastPaycheckDate."'";
$result = $conn->query($sql);

$moneySpent = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$moneySpent += doubleval(str_replace(',', '.', $row["Value"]));
    }
} else {
    echo "Error while fetching your last paycheck.";
}

$moneySpent *= -1;
echo "You spent <b class='moneySpent'>" . str_replace('.', ',', $moneySpent) . " €</b> since your last paycheck.<br>";

$moneyLeft = $lastPaycheckAmount - $moneySpent;
echo "You have <b class='moneyLeft'>" . str_replace('.', ',', $moneyLeft) . " €</b> left until your next paycheck.";
