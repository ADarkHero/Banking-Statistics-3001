@ECHO off
cd "C:\\Program Files (x86)\\Subsembly FinTS API"
FinCmd balance -contactfile "Export\ACCOUNTNUMBER.xml" -pin "PASSWORD" -acctno ACCOUNTNUMBER > PATHTOWEBSERVER\csv\balance.csv