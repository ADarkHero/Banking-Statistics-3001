<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

$rows = array_map(function($row) { return str_getcsv($row, ';'); }, file('csv/balance.csv'));

$spendableMoney = str_replace(",", ".", $rows[1][5])-$contractCosts;
echo "You currently have <b class='text-success moneyTotal'>" . bankNumberFormatComma($rows[1][5]) . " €</b> on your " . $rows[1][2] . " bank account!<br>";
echo "You could spend <b class='text-success moneyTotal'>" . bankNumberFormat($spendableMoney) . " €</b> if you dislike saving money!";
