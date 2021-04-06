<div class="col-12"><h1 class="mt-3">Settings</h1></div>

<div class="col-12"><h2 class="mt-3">Amazon CreditCard Import</h2></div>

<form enctype="multipart/form-data" action="settings.php" method="POST">
    <div class="input-group">
      <div class="custom-file">
        <input type="file" name="uploaded_file" class="custom-file-input" id="uploadAmazonCC"
          aria-describedby="uploadAmazonCC">
        <label class="custom-file-label" for="uploadAmazonCC">Choose Amazon Credit card file (CSV!)</label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary form-control">Submit</button>
</form>

<?php
  if(!empty($_FILES['uploaded_file'])){
    $path = $uploadPath;
    $path = $path . basename( $_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
      echo "The file ".  basename($_FILES['uploaded_file']['name']). " has been uploaded!<br>";
      readAmazonCC(basename( $_FILES['uploaded_file']['name']), $uploadPath, $creditCardCategory, $conn);
    } else{
        echo "There was an error uploading the file, please try again!";
    }
  }
  
  /*
   * Reads statements from the Amazon Credit Card csv file, you can 
   * download in their back end.
   * 
   * The csv file has the following structure:
   * Konto-/Kartennummer;Buchungsdatum;Kaufdatum;Umsatz/Ort;Fremdwährung;Kurs zu EUR;Betrag in EUR
   */
function readAmazonCC($filename, $path, $category, $conn){
    $filepath = $path . $filename;
      
    $row = 0;
      
      //Does the file exist?
    if (($handle = fopen($filepath, "r")) !== FALSE) { 
        
        //Try to read the file
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $num = count($data);
            $priceCC = doubleval(str_replace(",", ".", $data[8])) * -1;
            
            $row++;
            $sql = "INSERT INTO statements (AcctNo, EntryDate, Name1, PaymtPurpose, Value, CategoryID) " .
                    "VALUES ( " .
                    "\"" . $data[0] . "\", " .
                    "\"" . date("Y-m-d", strtotime($data[1])) . "\", " .
                    "\"" . $data[3] . "\", " .
                    "\"" . $data[3] . " ~ " . $data[1] . " ~ " . $data[8] . " &euro;\", " .
                    "\"" . $priceCC . "\", " .
                    $category . " )";
					
					//echo $sql;

            //Only import, if it's an actual transaction
            if($data[8] != null && $data[8] != "" && $data[8] != "0" && $data[8] != "0,00" && $data[8] != "Betrag in EUR"){
                $conn->query($sql);
                if($conn->affected_rows > 0){
                    echo $data[3] . " ~ " . $data[1] . " ~ " . $data[8] . " &euro; got inserted into the database!<br>";
                }
                else{
                    "No new entries got inserted.";
                }
            }
            
        }
        
        fclose($handle); //Close the file
    }
	else{
		echo "File is not readable.";
	}
  }
?>