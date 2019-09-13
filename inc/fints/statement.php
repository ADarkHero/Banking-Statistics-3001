<?php

require 'vendor/autoload.php';

use Fhp\FinTs;
use Fhp\Model\StatementOfAccount\Statement;
use Fhp\Model\StatementOfAccount\Transaction;

$fints = new FinTs(
    FHP_BANK_URL,
    FHP_BANK_PORT,
    FHP_BANK_CODE,
    FHP_ONLINE_BANKING_USERNAME,
    FHP_ONLINE_BANKING_PIN,
    null,
    FHP_REGISTRATION_NO,
    FHP_SOFTWARE_VERSION
);

try {
    $accounts = $fints->getSEPAAccounts();
     
    $fints->setTANMechanism(901); //901 -> Mobile TAN

    $oneAccount = $accounts[0];
    $from = new \DateTime('2019-09-11');
    $to   = new \DateTime();
    $soa = $fints->getStatementOfAccount($oneAccount, $from, $to);
        
    $serialized = serialize($soa);
        
    if($soa->isTANRequest()){
        file_put_contents("tan.txt", ""); //Clear TAN file
        
        //Wait, until TAN is added
        while(1){
                sleep(1);
                $tan = trim(file_get_contents("inc/fints/tan.txt"));
                if($tan == ""){
                        echo "No TAN found, waiting!\n";
                        continue;
                }
                break;
        }
        $unserialized = unserialize($serialized);
        $fints = new FinTs(
                FHP_BANK_URL,
                FHP_BANK_PORT,
                FHP_BANK_CODE,
                FHP_ONLINE_BANKING_USERNAME,
                FHP_ONLINE_BANKING_PIN,
                null,
                FHP_REGISTRATION_NO,
                FHP_SOFTWARE_VERSION
        );
        $soa = $fints->finishStatementOfAccount($unserialized, $oneAccount, $from, $to, $tan);

        $fints->end();  
    }
    
} catch (\Exception $ex) {
    echo 'Sth. went wrong - ' . $ex->getMessage();
    exit;
}



$newEntriesCounter = 0; //Counts, how much new entries are being made
for($i = 0; $i < sizeof($accounts); $i++){       
    $soa = $fints->getStatementOfAccount($accounts[$i], $from, $to);
        foreach ($soa->getStatements() as $statement) {
            foreach ($statement->getTransactions() as $transaction) {
                //SQL Statement
                $sql = "";
                $amnt = floatval($transaction->getAmount());
                if($transaction->getCreditDebit() == "debit"){
                    $amnt *= -1;
                }
                
                $sql .= "INSERT INTO statements (EntryDate, Value, AcctNo, BankCode, Name1, PaymtPurpose)"
                        . " VALUES ("  
                        . "'".$transaction->getBookingDate()->format('Y-m-d')."',"
                        . "'".$amnt."',"
                        . "'".$transaction->getAccountNumber()."',"
                        . "'".$transaction->getBankCode()."',"
                        . "'".$transaction->getName()."',"
                        . "'".$transaction->getDescription1()."'"
                        . ")";
                
                //Execute the query. If no error occured (like a duplicate entry), raise the counter.
                //If there are no new entries: break the loop
                //Note: The database checks for duplicates. A more effective/faster way should be implemented sometime.
                if ($conn->query($sql) === TRUE) {
                    $newEntriesCounter++;
                }
                else{
                    //Currently buggy?
                    //break 3;
                }
            }
        }	
}