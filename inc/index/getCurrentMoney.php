<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

$sql = "SELECT AccountNumber, AccountValue FROM account";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
     while($row = $result->fetch_assoc()) {
         $bankAccountNumber = $row["AccountNumber"];
         $bankAccountValue = $row["AccountValue"];
     }
}

$spendableMoney = str_replace(",", ".", $bankAccountValue)-$contractCosts;
echo "You currently have <b class='text-success moneyTotal'>" . bankNumberFormatComma($bankAccountValue) . " €</b> on your " . $bankAccountNumber . " bank account!<br>";
if($_GET["paycheckDate"] == 0){ echo "You could spend <b class='text-success moneyTotal'>" . bankNumberFormat($spendableMoney) . " €</b> if you dislike saving money!"; }
