<?php
/********************
DEPENDS ON
 * inc/index/lastPaycheck.php
 * inc/contract/paidContracts.php
********************/

$paycheckDay = date_create($lastPaycheckDate);
$currentDate = new DateTime("now");

$interval = date_diff($paycheckDay, $currentDate);
//Time until next paycheck
$timeToPaycheck = cal_days_in_month(CAL_GREGORIAN, date_format($paycheckDay->add(new DateInterval("P1M")), 'm'), 2019) - $interval->format('%a');

if($timeToPaycheck < 1){
    $timeToPaycheck = 1;
}

//Progress bar should always be 100%, when the month passed
if(isCurrentMonth()){
    generateProgressBar($timeToPaycheck);
}
else{
    generateProgressBar(0);
}


echo "You got your ";
if(isCurrentMonth()){ echo "last "; }
echo "paycheck on <b>" . $lastPaycheckDate . "</b>! It were <b class='text-success'>" . 
        bankNumberFormatComma($lastPaycheckAmount) . " ".$currency."</b>! ";

//Next paycheck date is unneccessary in past months
if(isCurrentMonth()){
    echo "You'll get your next paycheck in approximately <b>".$timeToPaycheck." day";
    if($timeToPaycheck !== 1){ //Checks, if it is day or days
        echo "s";
    }  
    echo "</b>. ";
}

echo "<br>";

/********************
 * How much money did we spent since then?
********************/
$sql = "SELECT Value, EntryDate, CategoryName, CategoryColor FROM statements "
        . "LEFT JOIN categories ON statements.CategoryID = categories.CategoryID "
        . "WHERE EntryDate >= '".$lastPaycheckDate."' AND EntryDate <= '".$nextPaycheckDate."' "
        . "AND AcctNo != '".$payCheckAccount."' "
        . "AND CategoryExcludeStats = 0 ORDER BY EntryDate";
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
                    if($row["Value"] <= 0){ //We don't need categories for positive values
                        $categorieColors[$row["CategoryName"]] = $row["CategoryColor"];
                    }
                }
                $moneyCategories[$row["CategoryName"]] += doubleval(str_replace(',', '.', $row["Value"])); 
                
                if(!isset($moneyByDate[$row["EntryDate"]])){ //If the date has no value yet, set it.
                    $moneyByDate[$row["EntryDate"]] = 0;
                }
                $moneyByDate[$row["EntryDate"]] += doubleval(str_replace(',', '.', $row["Value"]));  
                     
    }
} else {
    //echo "You didn't spend money since your last paycheck. ";
}

$moneySpent *= -1;
if(isCurrentMonth()){
    echo "You spent <b class='text-danger'>" . bankNumberFormat($moneySpent) . " ".$currency."</b> since your last paycheck. ";
}
else{
    echo "You spent <b class='text-danger'>" . bankNumberFormat($moneySpent) . " ".$currency."</b> that month. ";
}

if(isCurrentMonth()){
    echo "You still have to pay <b class='text-danger'>" . bankNumberFormat($contractCosts) . " ".$currency."</b> for your contracts.";
}
echo "<br>";

$moneyLeft = $lastPaycheckAmount - $moneySpent - $contractCosts;
if(isCurrentMonth()){
    echo "You have <b class='text-primary'>" . bankNumberFormat($moneyLeft) . " ".$currency."</b> left until your next paycheck. ";
}
else{
    echo "You had <b class='text-primary'>" . bankNumberFormat($moneyLeft) . " ".$currency."</b> left that month. ";
}

if(isCurrentMonth()){
    $moneyPerDay = $moneyLeft / $timeToPaycheck;
    echo "If you don't need to save money, you could spend <b class='text-primary'>" . bankNumberFormat($moneyPerDay) . " ".$currency."</b> per day.";
}








/********************
 * Generates the progress bar, so the user quickly sees, how much of the month passed.
********************/
function generateProgressBar($timeToPaycheck){
    $paycheckPercent = round(100 - $timeToPaycheck / 30 * 100, 2);
    if($paycheckPercent < 0){ $paycheckPercent = 0; }
    if($paycheckPercent > 100){ $paycheckPercent = 100; }
    
?>
    <div class="progress" data-toggle="tooltip" title="<?php echo $paycheckPercent;?>% of the month passed.">
        <div class="progress-bar progress-bar-striped <?php echo getProgressColor($paycheckPercent); ?>" role="progressbar" 
             style="width: <?php echo $paycheckPercent."%"; ?>" 
             aria-valuenow="<?php echo $paycheckPercent;?>" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>
<?php
}

/********************
 * Returns the color of the progress bar, based on the time left until the next paycheck arrives.
********************/
function getProgressColor($paycheckPercent){
    $progresscolor = "";
    
    switch(true){
        case ($paycheckPercent > 75): $progresscolor = "bg-success"; break;
        case ($paycheckPercent > 50): $progresscolor = "bg-info"; break;
        case ($paycheckPercent > 25): $progresscolor = "bg-warning"; break;
        default: $progresscolor = "bg-danger";
    }
    
    return $progresscolor;
}