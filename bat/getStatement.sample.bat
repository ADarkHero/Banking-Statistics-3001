@ECHO off
cd "C:\\Program Files (x86)\\Subsembly FinTS API"
FinCmd statement -contactfile "Export\ACCOUNTNUMBER.xml" -pin "PASSWORD" -acctno ACCOUNTNUMBER > PATHTOWEBSERVER\csv\statement.csv