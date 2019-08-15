<div id="accordion"> 
    
<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

$i = 0;
$paidSum = 0;
$leftSum = 0;
foreach ($paidContracts as $key => $value){
?>

<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-success">PAID</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-success"><?php echo $key; ?></span></div>   
                  <div class="col-12 col-lg-2"><span class="text-success"><?php echo bankNumberFormat($contractAmounts[$key])." ".$currency; ?></span></div> 
                  <?php $paidSum += $contractAmounts[$key]; ?>
              </div>    
            </div>         
        </button>
      </h5>
    </div>

    <div id="collapse<?php echo $i; ?>" class="collapse" aria-lebelledby="heading<?php echo $i; ?>" data-parent="#accordion">
        <div class="card-body">
        <form action="contract.php" method="POST">
            <div class="form-group row">
                <label for="changeContractName" class="col-3 col-form-label">Contract name</label>
                <div class="col-9"><input type="text" class="form-control" name="changeContractName" value="<?php echo $key; ?>"></div>
            </div>
            <div class="form-group row">
                <label for="changeContractValue" class="col-3 col-form-label">Contract value</label>
                <div class="col-9"><input type="text" class="form-control" name="changeContractValue" value="<?php echo $paidContracts[$key]; ?>"></div>
            </div>
            <div class="form-group row">
                <label for="changeContractNote" class="col-3 col-form-label">Contract note</label>
                <div class="col-9"><input type="text" class="form-control" name="changeContractNote" value="<?php echo $contractNotes[$key]; ?>"></div>
            </div>
            <div class="form-group row">
                <label for="changeContractAmount" class="col-3 col-form-label">Contract amount</label>
                <div class="col-9"><input type="number" step="0.01" class="form-control" name="changeContractAmount" value="<?php echo $contractAmounts[$key]; ?>"></div>
            </div>
            <div class="form-group row">
                <input type="hidden" class="form-control" name="changeContractNameOld" value="<?php echo $key; ?>">
                <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Change settings"></div>
            </div>
        </form>
      </div>
    </div>
  </div>

<?php

$i++;
}

foreach ($unpaidContracts as $key => $value){
?>

<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-danger">UNPAID</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-danger"><?php echo $key; ?></span></div>   
                  <div class="col-12 col-lg-2"><span class="text-danger"><?php echo bankNumberFormat($contractAmounts[$key])." ".$currency; ?></span></div> 
                  <?php $leftSum += $contractAmounts[$key]; ?>
              </div>    
            </div>         
        </button>
      </h5>
    </div>

    <div id="collapse<?php echo $i; ?>" class="collapse" aria-lebelledby="heading<?php echo $i; ?>" data-parent="#accordion">
      <div class="card-body">
            <form action="contract.php" method="POST">
                <div class="form-group row">
                    <label for="changeContractName" class="col-3 col-form-label">Contract name</label>
                    <div class="col-9"><input type="text" class="form-control" name="changeContractName" value="<?php echo $key; ?>"></div>
                </div>
                <div class="form-group row">
                    <label for="changeContractValue" class="col-3 col-form-label">Contract value</label>
                    <div class="col-9"><input type="text" class="form-control" name="changeContractValue" value="<?php echo $unpaidContracts[$key]; ?>"></div>
                </div>
                <div class="form-group row">
                    <label for="changeContractNote" class="col-3 col-form-label">Contract note</label>
                    <div class="col-9"><input type="text" class="form-control" name="changeContractNote" value="<?php echo $contractNotes[$key]; ?>"></div>
                </div>
                <div class="form-group row">
                    <label for="changeContractAmount" class="col-3 col-form-label">Contract amount</label>
                    <div class="col-9"><input type="number" step="0.01" class="form-control" name="changeContractAmount" value="<?php echo $contractAmounts[$key]; ?>"></div>
                </div>
                <div class="form-group row">
                    <input type="hidden" class="form-control" name="changeContractNameOld" value="<?php echo $key; ?>">
                    <div class="col-12"><input type="submit" class="btn btn-primary form-control" value="Change settings"></div>
                </div>
            </form>
      </div>
    </div>
  </div>


<?php

$i++;
}

$totalSum = $paidSum + $leftSum; 
$totalSpendable = $lastPaycheckAmount - $totalSum; 
?>
</div>

<br>

<div class="card">
    <div class="card-header" id="heading9994">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-primary">LAST PAYCHECK</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-primary">You got that much money this month: </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-primary"><?php echo $lastPaycheckAmount." ".$currency; ?></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>
<div class="card">
    <div class="card-header" id="heading9995">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-danger">TOTAL CONTRACTS</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-danger">You pay this much for contracts this month: </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-danger"><?php  echo bankNumberFormat($totalSum)." ".$currency; ?></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>
<div class="card">
    <div class="card-header" id="heading9996">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-success">MONEY ABLE TO SPEND</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-success">You are able to spent that much money freely this month: </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-success"><?php echo $totalSpendable." ".$currency; ?></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>
<div class="card">
    <div class="card-header" id="heading9997">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-primary"></span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-primary"> </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-primary"></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>

<div class="card">
    <div class="card-header" id="heading9998">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-success">TOTAL PAID</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-success">This month you already paid that much for your contracts: </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-success"><?php echo bankNumberFormat($paidSum)." ".$currency; ?></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>
<div class="card">
    <div class="card-header" id="heading9999">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button">
            <div class="container">
              <div class="row" >
                  <div class="col-12 col-lg-2"><span class="text-danger">TOTAL UNPAID</span></div>   
                  <div class="col-12 col-lg-8 cut"><span class="text-danger">This month you still have to pay that much for your contracts: </span></div>   
                  <div class="col-12 col-lg-2"><span class="text-danger"><?php echo bankNumberFormat($leftSum)." ".$currency; ?></span></div>   
              </div>    
            </div>         
        </button>
      </h5>
    </div>
  </div>