<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

$sql = "SELECT AccountNumber, AccountValue, AccountAlias FROM account";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $bankAccountNumber = array();
    $bankAccountValue = array();
    $bankAccountAlias = array();
     while($row = $result->fetch_assoc()) {
        array_push($bankAccountNumber, $row["AccountNumber"]);
        array_push($bankAccountValue, $row["AccountValue"]);
        array_push($bankAccountAlias, $row["AccountAlias"]);
     }
}


$moneySum = 0;
for($i = 0; $i < sizeof($bankAccountNumber); $i++){
    echo "You currently have <b class='text-success moneyTotal'>" . bankNumberFormatComma($bankAccountValue[$i]) . " €</b> on your " . $bankAccountNumber[$i] . 
            " (".$bankAccountAlias[$i].") "
            . "bank account!<br>";
    $moneySum += $bankAccountValue[$i];
}

$spendableMoney = $moneySum - $contractCosts;
if(isCurrentMonth()){ echo "You could spend <b class='text-success moneyTotal'>" . bankNumberFormat($spendableMoney) . " €</b> "
        . "of your <b class='text-success moneyTotal'>" . bankNumberFormat($moneySum) . " €</b> if you dislike saving money!"; }
