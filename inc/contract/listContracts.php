<?php
/********************
DEPENDS ON
 * inc/contract/paidContracts.php
********************/

$i = 0;
foreach ($paidContracts as $key => $value){
?>

<div class="card">
    <div class="card-header" id="heading<?php echo $i; ?>">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed full-size-button" data-toggle="collapse" data-target="#collapse<?php echo $i; ?>" aria-expanded="false" aria-controls="collapse<?php echo $i; ?>">
            <div class="container">
              <div class="row" >
                  <div class="col-2"><span class="text-success">PAID</span></div>   
                  <div class="col-8 cut"><span class="text-success"><?php echo $key; ?></span></div>   
                  <div class="col-2"><span class="text-success"><?php echo bankNumberFormat($contractAmounts[$key])." ".$currency; ?></span></div> 
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
                <label for="changeContractAmount" class="col-3 col-form-label">Contract amount</label>
                <div class="col-9"><input type="number" class="form-control" name="changeContractAmount" value="<?php echo $contractAmounts[$key]; ?>"></div>
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
                  <div class="col-2"><span class="text-danger">UNPAID</span></div>   
                  <div class="col-8 cut"><span class="text-danger"><?php echo $key; ?></span></div>   
                  <div class="col-2"><span class="text-danger"><?php echo bankNumberFormat($contractAmounts[$key])." ".$currency; ?></span></div> 
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
                    <label for="changeContractAmount" class="col-3 col-form-label">Contract amount</label>
                    <div class="col-9"><input type="number" class="form-control" name="changeContractAmount" value="<?php echo $contractAmounts[$key]; ?>"></div>
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