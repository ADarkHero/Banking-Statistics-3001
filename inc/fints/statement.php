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

    $oneAccount = $accounts[0];
    $from = new \DateTime('2019-09-12');
    $to   = new \DateTime();
    $soa = $fints->getStatementOfAccount($oneAccount, $from, $to);

    if($soa->isTANRequest()){
            $serialized = serialize($soa);
            echo "Waiting max. 60 seconds for TAN\n";
            for($i = 0; $i < 60; $i++){
                    sleep(1);
                    $tan = trim(file_get_contents("tan.txt"));
                    if($tan == ""){
                            echo "No TAN found, waiting ".(60 - $i)."!\n";
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
    }
    $fints->end();


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