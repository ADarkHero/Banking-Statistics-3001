<?php

$rows = array_map(function($row) { return str_getcsv($row, ';'); }, file('csv/balance.csv'));

echo "You currently have <b class='text-success moneyTotal'>" . bankNumberFormatComma($rows[1][5]) . " €</b> on your " . $rows[1][2] . " bank account!";
