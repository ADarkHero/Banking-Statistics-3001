<?php
$disablenext = false;
if (isset($_GET["year"])) {
    $year = htmlspecialchars($_GET["year"]);
} else {
    $year = date("Y");
}

if ($year == date("Y")) {
    $disablenext = true;
}
?>


<script src="js/chartjs-plugin-datalabels.min.js"></script>

<script>
    function chartOpenStatements(event, data) {
        if (data[0]) {
            var ticks = data[0]["_xScale"]["ticks"];
            var index = data[0]["_index"];
            var clickedValue = ticks[index];


            //All months
            var months = ["January", "February", "March", "April",
                "May", "June", "July", "August",
                "September", "October", "November", "December"];
            //Get number of the month
            var monthNumber = months.indexOf(clickedValue) + 1;

            //Only change the date, if it's actually a date
            if (monthNumber != "0") {
                //If the month is smaller than 10, add a 0 in front of it.
                if (monthNumber < 10) {
                    clickedValue = "-0" + monthNumber + "-";
                } else {
                    clickedValue = "-" + monthNumber + "-";
                }
                //Add year
                clickedValue = <?php echo $year; ?> + clickedValue;
            }


            var link = 'statement.php?search=' + clickedValue + '%26' + <?php echo $year; ?>;
            window.open(link, '_blank');
        }
    }
</script>


<div class="row">
    <div class="col-12 col-md-9"><h1 class="mt-3">Yearly statistics</h1></div>
    <div class="col-12 col-md-3">
        <nav aria-label="Statement Navigation">
            <ul class="pagination mt-4 center justify-content-center justify-content-md-end">
                <li class="page-item"><a class="page-link" href="yearly.php?year=<?php echo $year - 1; ?>">Previous</a></li>
                <li class="page-item disabled"><a class="page-link" href="#"><b><?php echo $year; ?></b></a></li>
                <li class="page-item 
                <?php
                if ($disablenext) {
                    echo "disabled";
                }
                ?>
                    "><a class = "page-link" href = "yearly.php?year=<?php echo $year + 1; ?>">Next</a></li>
            </ul>
        </nav>
    </div>
</div>



<div class="containter">
    <div class="row">
        <div class="col-12 col-lg-12"><h3 class="mt-5">Money spent per year per categories</h3><canvas id="moneySpent"></canvas></div> 
    </div>
    <div class="row">
        <div class="col-12 col-lg-12"><h3 class="mt-5">Money change per month</h3><canvas id="moneyTime"></canvas></div> 
    </div>
</div>    


<?php
$yearStart = $year . "-01-01";
$yearEnd = $year . "-12-31";

$sql = "SELECT Value, EntryDate, CategoryName, CategoryColor FROM statements "
        . "LEFT JOIN categories ON statements.CategoryID = categories.CategoryID "
        . "WHERE EntryDate >= '" . $yearStart . "' AND EntryDate <= '" . $yearEnd . "' "
        . "AND CategoryExcludeStats = 0 ORDER BY EntryDate";
$result = $conn->query($sql);

$moneyByDate = array(); //Money by date
$moneyByMonth = array(); //Money by month
$moneyCategories = array(); //Money spent by category
$categorieColors = array(); //Colors of the categories
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if (!isset($moneyCategories[$row["CategoryName"]])) { //If the category has no value yet, set it.
            $moneyCategories[$row["CategoryName"]] = 0;
        }

        if (!isset($categorieColors[$row["CategoryName"]])) { //Do we already have the category color?
            $categorieColors[$row["CategoryName"]] = $row["CategoryColor"];
        }
        $moneyCategories[$row["CategoryName"]] += doubleval(str_replace(',', '.', $row["Value"]));

        if (!isset($moneyByDate[$row["EntryDate"]])) { //If the date has no value yet, set it.
            $moneyByDate[$row["EntryDate"]] = 0;
        }
        $moneyByDate[$row["EntryDate"]] += doubleval(str_replace(',', '.', $row["Value"]));

        $monthNum = substr($row["EntryDate"], 5, -3); //Get month number
        $monthName = date('F', mktime(0, 0, 0, $monthNum, 10));
        if (!isset($moneyByMonth[$monthName])) { //If the month has no value yet, set it.
            $moneyByMonth[$monthName] = 0;
        }
        $moneyByMonth[$monthName] += doubleval(str_replace(',', '.', $row["Value"]));
    }
} else {
    //echo "You didn't spend money since your last paycheck. ";
}
arsort($moneyCategories);
?>

<script>
    var ctx = document.getElementById("moneySpent");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [

<?php
$valuesString = "";
/*
 * Names of each category
 */
foreach ($moneyCategories as $key => $value) {
//Only show entries, you SPENT money on.
//Don't show entries, where you gained money.
    $valuesString .= '"' . $key . '", ';
}
echo substr($valuesString, 0, -2); //Cut last ,
?>

            ],
            datasets: [{
                    label: '',
                    data: [

<?php
$valuesString = "";
/*
 * Values of each category
 */
foreach ($moneyCategories as $key => $value) {
//Only show entries, you SPENT money on.
//Don't show entries, where you gained money.
    $valuesString .= '"' . $value . '", ';
}
echo substr($valuesString, 0, -2); //Cut last ,
?>


                    ],
                    backgroundColor: [

<?php
$colorsString = "";
/*
 * Background color of each category
 */
foreach ($moneyCategories as $key => $value) {
    list($r, $g, $b) = sscanf($categorieColors[$key], "#%02x%02x%02x");
    $colorsString .= "'rgba(" . $r . ", " . $g . ", " . $b . ", 0.4)', ";
}
echo substr($colorsString, 0, -2); //Cut last ,
?>


                    ],
                    borderColor: [

<?php
$borderString = "";
/*
 * Border color of each category
 */
foreach ($moneyCategories as $key => $value) {
    list($r, $g, $b) = sscanf($categorieColors[$key], "#%02x%02x%02x");
    $borderString .= "'rgba(" . $r . ", " . $g . ", " . $b . ", 1)', ";
}
echo substr($borderString, 0, -2); //Cut last ,
?>


                    ],
                    borderWidth: <?php echo $chartBorderWidth; ?>
                }]
        },
        options: {
            plugins: {
                datalabels: {
                    align: 'end',
                    anchor: 'end',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: <?php echo $chartFontSize; ?>
                        }
                    }],
                xAxes: [{
                        ticks: {
                            autoSkip: false,
                            fontSize: <?php echo $chartFontSize; ?>
                        }
                    }]
            },
            onClick: chartOpenStatements

        }
    });</script>






<script>
    var ctx = document.getElementById("moneyTime");
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
<?php
$motLabels = "";
foreach ($moneyByMonth as $key => $value) {
    $motLabels .= '"' . $key . '", ';
}
echo substr($motLabels, 0, -2); //Cut last ,
?>
            ],
            datasets: [{
                    label: '',
                    data: [
<?php
$motString = "";
$motLeft = 0;
foreach ($moneyByMonth as $key => $value) {
    $motLeft += floatval($value);
    $motString .= '"' . $motLeft . '", ';
}
echo substr($motString, 0, -2); //Cut last ,
?>
                    ],
                    backgroundColor: [
                        'rgba(<?php echo $colorMoneyOverTime; ?>, <?php echo $chartFill; ?>)'
                    ],
                    borderColor: [
                        'rgba(<?php echo $colorMoneyOverTime; ?>, <?php echo $chartBorder; ?>)'
                    ],
                    borderWidth: <?php echo $chartBorderWidth; ?>
                }]
        },
        options: {
            plugins: {
                datalabels: {
                    align: 'start',
                    anchor: 'end',
                    font: {
                        weight: 'bold'
                    }
                }
            },
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: <?php echo $chartFontSize; ?>
                        }
                    }],
                xAxes: [{
                        ticks: {
                            fontSize: <?php echo $chartFontSize; ?>
                        }
                    }]
            },
            onClick: chartOpenStatements
        }
    });
</script>

