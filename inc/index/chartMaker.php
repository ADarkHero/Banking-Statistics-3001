<div class="containter">
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money spent this month</h3><canvas id="moneySpent"></canvas></div> 
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money over time</h3><canvas id="myChart03"></canvas></div> 
    </div>
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money to save</h3><canvas id="moneySave"></canvas></div> 
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money by categories</h3><canvas id="moneyCategories"></canvas></div> 
    </div>
</div>    

<script>
var ctx = document.getElementById("moneySpent");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Paycheck", "Money left", "Money spent"],
        datasets: [{
            label: 'Money spent this month',
            data: [<?php echo str_replace(",", ".", $lastPaycheckAmount); ?>, <?php echo $moneyLeft; ?>, <?php echo $moneySpent; ?>],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<script>
var ctx = document.getElementById("moneySave");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Money to save", "Current money"],
        datasets: [{
            label: 'How much money should you save?',
            data: [<?php $moneyToSave = str_replace(",", ".", $lastPaycheckAmount)*3-str_replace(",", ".", $rows[1][5]); echo $moneyToSave; ?>,
                   <?php echo str_replace(",", ".", $rows[1][5]); ?>],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    }
});
</script>

<script>
var ctx = document.getElementById("moneyCategories");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: [
        <?php 
            $labelsString = "";
            foreach ($moneyCategories as $key => $value) {
                $labelsString .= '"'.$key.'", ';
            }
            echo $labelsString;
            echo '"Money left"';
        ?>],
        datasets: [{
            label: 'How much money did we spent in each category?',
            data: [
                <?php 
                    $valuesString = "";
                    foreach ($moneyCategories as $key => $value) {
                        $valuesString .= '"'.$value.'", ';
                    }
                    echo $valuesString;
                    echo '"'.$moneyLeft.'"';
                ?>
            ],
            backgroundColor: [
                <?php 
                    $colorsString = "";
                    foreach ($categorieColors as $key => $value) {
                        $colorsString .= '"'.$value.'", ';
                    }
                    echo $colorsString;
                    echo "'rgba(54, 162, 235, 0.2)'";
                ?>
            ],
            borderColor: [
                <?php
                    $borderString = "";
                    for($i = 0; $i <= sizeof($moneyCategories); $i++){
                        $borderString .= "'rgba(0, 0, 0, 0.2)', ";
                    }
                    echo substr($borderString, 0, -2); //Removes last ,
                ?>
            ],
        }]
    }
});
</script>