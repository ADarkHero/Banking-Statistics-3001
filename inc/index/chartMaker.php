<div class="containter">
    <div class="row">
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money spent this month</h3></div> 
        <div class="col-12 col-lg-6"><h3 class="mt-5">Money to save</h3></div> 
    </div>
    <div class="row">
        <div class="col-12 col-lg-6"><canvas id="myChart"></canvas></div> 
        <div class="col-12 col-lg-6"><canvas id="myChart02"></canvas></div> 
    </div>
</div>    

<script>
var ctx = document.getElementById("myChart");
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
var ctx = document.getElementById("myChart02");
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ["Current money", "Money you should save"],
        datasets: [{
            label: 'How much money should you save?',
            data: [<?php echo str_replace(",", ".", $rows[1][5]); ?>, 
                   <?php $moneyToSave = str_replace(",", ".", $lastPaycheckAmount)*3-str_replace(",", ".", $rows[1][5]); echo $moneyToSave; ?>],
            backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(54, 162, 235, 1)' 
            ],
            borderWidth: 1
        }]
    }
});
</script>