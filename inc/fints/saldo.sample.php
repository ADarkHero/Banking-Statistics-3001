<?php


require 'vendor\autoload.php';

use Fhp\FinTs;
use Fhp\Model\StatementOfAccount\Statement;
use Fhp\Model\StatementOfAccount\Transaction;

define('FHP_BANK_URL', 'https://hbci11.fiducia.de/cgi-bin/hbciservlet');                 # HBCI / FinTS Url can be found here: https://www.hbci-zka.de/institute/institut_auswahl.htm (use the PIN/TAN URL)
define('FHP_BANK_PORT', 443);               # HBCI / FinTS Port can be found here: https://www.hbci-zka.de/institute/institut_auswahl.htm
define('FHP_BANK_CODE', 50031000);                # Your bank code / Bankleitzahl
define('FHP_ONLINE_BANKING_USERNAME', '');  # Your online banking username / alias
define('FHP_ONLINE_BANKING_PIN', '');       # Your online banking PIN (NOT! the pin of your bank card!)

    $fints = new FinTs(
        FHP_BANK_URL,
        FHP_BANK_PORT,
        FHP_BANK_CODE,
        FHP_ONLINE_BANKING_USERNAME,
        FHP_ONLINE_BANKING_PIN
    );

    $accounts = $fints->getSEPAAccounts();
    
    print_r($accounts);
    
    //Update account value
    for($i = 0; $i < sizeof($accounts); $i++){ 
        $amount = $fints->getSaldo($accounts[$i])->getAmount();
        $accNumber = $accounts[$i]->getAccountNumber();
        $sql = "UPDATE account SET AccountValue = '".$amount."' WHERE AccountNumber = '".$accNumber."'";
        $conn->query($sql);
        if($conn->affected_rows == 0){
            $sql = "INSERT INTO account (AccountValue, AccountNumber) VALUES ('".$amount."', '".$accNumber."')";
            $conn->query($sql);
        }
    }



