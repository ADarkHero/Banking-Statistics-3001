<?php
require_once('lastPaycheck.php');

$timestamp = strtotime($lastPaycheckDate);
$day = date('d', $timestamp);
$timeToPaycheck = abs($day - date('d'));

echo "You got your last paycheck on <b>" . $lastPaycheckDate . "</b>! It were <b class='text-success'>" . $lastPaycheckAmount . " €</b>! "
        . "You'll get your next paycheck in approximately <b>".$timeToPaycheck." day/s.</b><br>";

/********************
How much money did we spent since then?
********************/
$sql = "SELECT Value, EntryDate, CategoryName, CategoryColor FROM statements "
        . "LEFT JOIN categories ON statements.CategoryID = categories.CategoryID "
        . "WHERE EntryDate >= '".$lastPaycheckDate."' AND Value < 0";
        
$result = $conn->query($sql);

$moneySpent = 0; //Total money spent
$moneyByDate = array(); //Money by date
$moneyCategories = array(); //Money spent by category
$categorieColors = array(); //Colors of the categories
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$moneySpent += doubleval(str_replace(',', '.', $row["Value"]));
                
                if(!isset($moneyCategories[$row["CategoryName"]])){ //If the category has no value yet, set it.
                    $moneyCategories[$row["CategoryName"]] = 0;
                }
                
                if(!isset($categorieColors[$row["CategoryName"]])){ //Do we already have the category color?
                    $categorieColors[$row["CategoryName"]] = $row["CategoryColor"];
                }
                $moneyCategories[$row["CategoryName"]] += doubleval(str_replace(',', '.', $row["Value"])); 
                
                if(!isset($moneyByDate[$row["EntryDate"]])){ //If the date has no value yet, set it.
                    $moneyByDate[$row["EntryDate"]] = 0;
                }
                $moneyByDate[$row["EntryDate"]] += doubleval(str_replace(',', '.', $row["Value"]));       
    }
} else {
    echo "Error while fetching your last paycheck.";
}

$moneySpent *= -1;
echo "You spent <b class='text-danger'>" . str_replace('.', ',', $moneySpent) . " €</b> since your last paycheck.<br>";

$moneyLeft = $lastPaycheckAmount - $moneySpent;
echo "You have <b class='text-primary'>" . str_replace('.', ',', $moneyLeft) . " €</b> left until your next paycheck.";