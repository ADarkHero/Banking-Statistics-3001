<?php

//Defined in saldo.php
//$fints = require 'login.php';

$newEntriesCounter = 0; //Counts, how much new entries are being made

try {
	$getSepaAccounts = \Fhp\Action\GetSEPAAccounts::create();
	$fints->execute($getSepaAccounts);
	if ($getSepaAccounts->needsTan()) {
		handleStrongAuthentication($getSepaAccounts); // See login.php for the implementation.
	}
	$oneAccount = $getSepaAccounts->getAccounts()[0];

    $from = new \DateTime($lastDBUpdate);
    $to = new \DateTime();
    $getStatement = \Fhp\Action\GetStatementOfAccount::create($oneAccount, $from, $to);
	$fints->execute($getStatement);
		
	if ($getStatement->needsTan()) {
		handleStrongAuthentication($getStatement); // See login.php for the implementation.
	}

	$soa = $getStatement->getStatement();
		
	foreach ($soa->getStatements() as $statement) {
		foreach ($statement->getTransactions() as $transaction) {
			
			echo 'Amount      : ' . ($transaction->getCreditDebit() == \Fhp\Model\StatementOfAccount\Transaction::CD_DEBIT ? '-' : '') . $transaction->getAmount() . PHP_EOL;
        echo 'Booking text: ' . $transaction->getBookingText() . PHP_EOL;
        echo 'Name        : ' . $transaction->getName() . PHP_EOL;
        echo 'Description : ' . $transaction->getMainDescription() . PHP_EOL;
        echo 'EREF        : ' . $transaction->getEndToEndID() . PHP_EOL;
        echo '=======================================' . PHP_EOL . PHP_EOL;
			
			//SQL Statement
			$sql = "";
			$amnt = floatval(($transaction->getCreditDebit() == \Fhp\Model\StatementOfAccount\Transaction::CD_DEBIT ? '-' : '') . $transaction->getAmount());

			$sql .= "INSERT INTO statements (EntryDate, Value, AcctNo, BankCode, Name1, PaymtPurpose)"
					. " VALUES ("
					. "'" . $transaction->getBookingDate()->format('Y-m-d') . "',"
					. "'" . $amnt . "',"
					. "'" . $transaction->getAccountNumber() . "',"
					. "'" . $transaction->getBankCode() . "',"
					. "'" . $transaction->getName() . "',"
					. "'" . $transaction->getMainDescription() . "'"
					. ")";

			//Execute the query. If no error occured (like a duplicate entry), raise the counter.
			//If there are no new entries: break the loop
			//Note: The database checks for duplicates. A more effective/faster way should be implemented sometime.
			if ($conn->query($sql) === TRUE) {
				$newEntriesCounter++;
			} else {
				//Currently buggy?
				//break 3;
			}
		}
	}
	
} catch (\Exception $ex) {
    echo 'Exception: ' . $ex->getMessage();
    exit;
}