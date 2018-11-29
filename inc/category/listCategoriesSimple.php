<?php 
/********************
Categories
********************/
$contracts = array();
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
$moneySpent = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo "<span style='color:".$row["CategoryColor"]."' "
                        . "data-toggle='tooltip' title='Colorcode: ".$row["CategoryColor"]."'>"
                        . $row["CategoryName"]."</span><br>";
    }
} else {
    echo "Error while fetching your categories. Do you have any?";
}