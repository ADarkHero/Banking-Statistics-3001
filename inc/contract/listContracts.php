<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

foreach ($paidContracts as $key => $value){
    echo "You already <b class='text-success'>paid</b> about ".bankNumberFormat($contractAmounts[$key])." ".$currency." "
            . "for your contract \"<b class='text-success'>".$key."</b>\" yet!<br>";
}

foreach ($unpaidContracts as $key => $value){
    echo "You <b class='text-danger'>didn't pay</b> about ".bankNumberFormat($contractAmounts[$key])." ".$currency." "
            . "for your contract \"<b class='text-danger'>".$key."</b>\" yet!<br>";
}

echo "<br>You still have to pay <b class='text-danger'>" . bankNumberFormat($contractCosts) . " ".$currency."</b> for your contracts.<br>";