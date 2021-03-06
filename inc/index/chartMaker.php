<?php
/* * ******************
  DEPENDS ON
 * inc/index/lastPaycheck.php
 * inc/index/getCurrentMoney.php
 * inc/index/moneySpent.php
 * inc/contract/paidContracts.php
 * ****************** */
?>

<div class="containter">
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money spent this month</h3><canvas id="moneySpent"></canvas></div> 
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money over time</h3><canvas id="moneyTime"></canvas></div> 
    </div>
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money to save</h3><canvas id="moneySave"></canvas></div> 
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money by categories</h3><canvas id="moneyCategories"></canvas></div> 
    </div>
</div>    

<script>
    function lineChartOpenStatements(event, data) {
        if (data[0]) {
            var ticks = data[0]["_xScale"]["ticks"];
            var index = data[0]["_index"];
            var clickedValue = ticks[index];
            var link = 'statement.php?search=' + clickedValue;
            window.open(link, '_blank');
        }
    }

    function pieChartOpenStatements(event, data) {
        if (data[0]) {
            var items = data[0]["_chart"]["legend"]["legendItems"];
            var index = data[0]["_index"];
            var clickedValue = items[index]["text"];
            var link = "";
            switch (clickedValue) {
                case "Unpaid contracts":
                    link = 'contract.php';
                    break;
                case "Money left":
                    link = 'statement.php';
                    break;
                default:
                    link = 'statement.php?search=' + clickedValue + '>' +
                            '<?php echo $lastPaycheckDate; ?>' + '<' +
                            '<?php echo $nextPaycheckDate; ?>';
            }
            window.open(link, '_blank');
        }
    }
</script>

<script>
    var ctx = document.getElementById("moneySpent");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["Paycheck", "Money left", "Money spent", "Unpaid contracts"],
            datasets: [{
                    label: '',
                    data: [<?php echo str_replace(",", ".", $lastPaycheckAmount); ?>, <?php echo $moneyLeft; ?>, <?php echo $moneySpent; ?>, <?php echo $contractCosts; ?>],
                    backgroundColor: [
                        'rgba(<?php echo $colorPaycheck; ?>, <?php echo $chartFill; ?>)',
                        'rgba(<?php echo $colorMoneyLeft; ?>, <?php echo $chartFill; ?>)',
                        'rgba(<?php echo $colorMoneySpent; ?>, <?php echo $chartFill; ?>)',
                        'rgba(<?php echo $colorContractCosts; ?>, <?php echo $chartFill; ?>)'
                    ],
                    borderColor: [
                        'rgba(<?php echo $colorPaycheck; ?>, <?php echo $chartBorder; ?>)',
                        'rgba(<?php echo $colorMoneyLeft; ?>, <?php echo $chartBorder; ?>)',
                        'rgba(<?php echo $colorMoneySpent; ?>, <?php echo $chartBorder; ?>)',
                        'rgba(<?php echo $colorContractCosts; ?>, <?php echo $chartBorder; ?>)'
                    ],
                    borderWidth: <?php echo $chartBorderWidth; ?>
                }]
        },
        options: {
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
            }
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
foreach ($moneyByDate as $key => $value) {
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
$motLeft = floatval($lastPaycheckAmount);
foreach ($moneyByDate as $key => $value) {
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
                            fontSize: <?php echo $chartFontSize; ?>,
                            autoSkip: false
                        }
                    }]
            },
            onClick: lineChartOpenStatements
        }
    });</script>





<script>
    var ctx = document.getElementById("moneySave");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Money to save", "Current money", "Unpaid contracts"],
            datasets: [{
                    label: '',
                    data: [
<?php
$lPaycheck = str_replace(",", ".", $lastPaycheckAmount);
$sumMoney = str_replace(",", ".", $moneySum);
$moneyToSave = $lPaycheck * $moneySaveRatio - $sumMoney + $contractCosts;
if ($moneyToSave > 0) {
    echo $moneyToSave;
} else {
    echo "0";
}
?>,
<?php echo $spendableMoney; ?>,
<?php echo $contractCosts; ?>
                    ],
                    backgroundColor: [
                        'rgba(<?php echo $colorMoneyToSave; ?>, <?php echo $chartFill; ?>)',
                        'rgba(<?php echo $colorCurrentMoney; ?>, <?php echo $chartFill; ?>)',
                        'rgba(<?php echo $colorContractCosts; ?>, <?php echo $chartFill; ?>)'
                    ],
                    borderColor: [
                        'rgba(<?php echo $colorMoneyToSave; ?>, <?php echo $chartBorder; ?>)',
                        'rgba(<?php echo $colorCurrentMoney; ?>, <?php echo $chartBorder; ?>)',
                        'rgba(<?php echo $colorContractCosts; ?>, <?php echo $chartBorder; ?>)'
                    ],
                    borderWidth: <?php echo $chartBorderWidth; ?>
                }]
        },
        options: {
            legend: {
                display: true,
                labels: {
                    fontSize: <?php echo $chartFontSize; ?>
                }
            }
        }
    });</script>





<script>
    var ctx = document.getElementById("moneyCategories");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: [
<?php
$labelsString = "";
foreach ($moneyCategories as $key => $value) {
    $labelsString .= '"' . $key . '", ';
}
echo $labelsString;
echo '"Unpaid contracts", ';
echo '"Money left"';
?>
            ],
            datasets: [{
                    label: '',
                    data: [
<?php
$valuesString = "";
foreach ($moneyCategories as $key => $value) {
    //Only show entries, you SPENT money on.
    //Don't show entries, where you gained money.
    $valuesString .= '"' . $value . '", ';
}
echo $valuesString;
echo '"-' . $contractCosts . '", ';
if ($moneyLeft > 0) {
    echo '"' . $moneyLeft . '"';
} else {
    echo '"0"';
}
?>
                    ],
                    backgroundColor: [
<?php
$colorsString = "";
foreach ($categorieColors as $key => $value) {
    list($r, $g, $b) = sscanf($value, "#%02x%02x%02x");
    $colorsString .= "'rgba(" . $r . ", " . $g . ", " . $b . ", 0.4)', ";
}
echo $colorsString;
echo "'rgba(" . $colorContractCosts . ", " . $chartFill . ")', ";
echo "'rgba(" . $colorMoneyLeft . ", " . $chartFill . ")'";
?>
                    ],
                    borderColor: [
<?php
$borderString = "";
foreach ($categorieColors as $key => $value) {
    list($r, $g, $b) = sscanf($value, "#%02x%02x%02x");
    $borderString .= "'rgba(" . $r . ", " . $g . ", " . $b . ", 1)', ";
}
echo $borderString;
echo "'rgba(" . $colorContractCosts . ", " . $chartBorder . ")', ";
echo "'rgba(" . $colorMoneyLeft . ", " . $chartBorder . ")'";
?>
                    ],
                    borderWidth: <?php echo $chartBorderWidth; ?>
                }]
        },
        options: {
            legend: {
                display: true,
                labels: {
                    fontSize: <?php echo $chartFontSize; ?>
                }
            },
            onClick: pieChartOpenStatements
        }
    });
</script>