<form action="index.php" method="post">
	<input type="hidden" name="updateDB" value="true">
	<input type="submit" value="Update Database">
</form>


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
The filename is "out.csv" and its seperated with semicolons
********************/
$rows = array_map(function($row) { return str_getcsv($row, ';'); }, file('csv/statement.csv'));



/********************
Generate and execute sql queries
********************/
$newEntriesCounter = 0; //Counts, how much new entries are being made
for($x = 1; $x < sizeof($rows); $x++){
	$sql = "INSERT INTO statements VALUES ("; //Beginning of the sql statement
	if(isSet($rows[$x][1])){ //Theres sometimes a empty line in the csv. Empty lines count as one single column. Empty lines get skipped, of course.
		for($i = 0; $i < 16; $i++){ //Iterate throught the csv colums and adds it to the sql statement
			$sql .= "'".$rows[$x][$i]."', ";
		}
	}
	$sql = substr($sql, 0, -2);
	$sql .= ")"; //Finish the sql statement

	//Execute the query. If no error occured (like a duplicate entry), raise the counter.
	//Note: The database checks for duplicates. A more effective/faster way should be implemented sometime.
	if ($conn->query($sql) === TRUE) {
		$newEntriesCounter++;
	} 
}



/********************
Success Message
********************/
if($newEntriesCounter > 0){
    echo "<p class='newEntries'><b class='successMessage'>".$newEntriesCounter."</b> new transaction";
    if($newEntriesCounter = 1){
        echo "s";
    }
    echo " got inserted into the database!</p>";
}
else{
    echo "<p class='newEntries errorMessage'>No new transactions!</p>";
}

}
?>
