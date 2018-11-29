<?php
/********************
DEPENDS ON
 * inc/contract/listContracts.php
********************/
	
if(isSet($_POST["changeContractName"]) && isSet($_POST["changeContractValue"]) && isSet($_POST["changeContractAmount"])){
    $sql = "UPDATE contracts SET  "
            . "ContractName = '".htmlspecialchars($_POST["changeContractName"])."', "
            . "ContractValue = '".htmlspecialchars($_POST["changeContractValue"])."', "
            . "ContractAmount = '".htmlspecialchars($_POST["changeContractAmount"])."' "
            . "WHERE ContractName = '".htmlspecialchars($_POST["changeContractName"])."'"; //SQL statement
    
    if ($conn->query($sql) === TRUE) {
            echo "<p class='successMessage'>The contract \"".htmlspecialchars($_POST["changeContractName"])."\" was edited.</p>";
    } 
    else{
            echo "<p class='errorMessage'>Error while editing the contract from the database.</p>";
    }

    echo "<br>";
}

?>