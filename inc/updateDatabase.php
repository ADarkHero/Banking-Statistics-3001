<?php
if(isSet($_POST["updateDB"])){

/********************
Download the account statement & balance via Subsemly FinTS API
The batch file download the statement and balance and places it into the correct folder
********************/
exec("bat\getStatement.bat");
exec("bat\getBalance.bat");



/********************
Parse the downloaded csv into an array
The filename is "statement.csv" and its seperated with semicolons
********************/
$statementrows = array_map(function($statementrows) { return str_getcsv($statementrows, ';'); }, file('csv/statement.csv'));
$balancerows = array_map(function($balancerows) { return str_getcsv($balancerows, ';'); }, file('csv/balance.csv'));



/********************
Generate and execute sql queries
********************/
$newEntriesCounter = 0; //Counts, how much new entries are being made
for($x = 1; $x < sizeof($statementrows); $x++){
	$sql = "INSERT INTO statements VALUES ("; //Beginning of the sql statement
	if(isSet($statementrows[$x][1])){ //Theres sometimes a empty line in the csv. Empty lines count as one single column. Empty lines get skipped, of course.
		for($i = 0; $i < 16; $i++){ //Iterate throught the csv colums and adds it to the sql statement
			$sql .= "'".$statementrows[$x][$i]."', ";
		}
	}
	$sql = substr($sql, 0, -2);
	$sql .= ", 0)"; //Finish the sql statement; 0 is for the category id
        
	//Execute the query. If no error occured (like a duplicate entry), raise the counter.
	//Note: The database checks for duplicates. A more effective/faster way should be implemented sometime.
	if ($conn->query($sql) === TRUE) {
		$newEntriesCounter++;
	} 
}

//Update account value
$sql = "UPDATE account SET AccountValue = '".$balancerows[1][5]."' WHERE AccountNumber = '".$balancerows[1][2]."'";
$conn->query($sql);





}
?>
<form action="index.php" class="inline" method="post">
	<input type="hidden" name="updateDB" value="true">
	<input type="submit" class="inline btn 
            <?php 
                if(!isSet($newEntriesCounter)){ echo "btn-light"; } 
                else if($newEntriesCounter > 0){ echo "btn-success"; } 
                else if($newEntriesCounter == 0){ echo "btn-warning"; } 
            ?>" value="Update Database">
</form>

<?php
/********************
Success Message
********************/
if(isSet($_POST["updateDB"])){
    if($newEntriesCounter > 0){
        echo "<p class='newEntries inline'><b class='successMessage'>".$newEntriesCounter."</b> new transaction";
        if($newEntriesCounter !== 1){
            echo "s";
        }
        echo " got inserted into the database!</p>";
    }
    else{
        echo "<p class='newEntries inline errorMessage'>No new transactions!</p>";
    }
}
?>