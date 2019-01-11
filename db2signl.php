#!/usr/bin/php
<?php
// SIGNL4 team URL (Replace <team-secret> by your SIGNL4 team secret)
const STRING_SIGNL4_URL 	= "https://account.signl4.com/webhook/<team-secret>";

// Thresholds (time in minutes, temperature in Celsius degrees)
const INT_TIME          = 10;
const INT_TEMPERATURE   = 40;

const STRING_DB_HOST        = "localhost";
const STRING_DB_NAME        = "signl4";
const STRING_DB_PASS        = "signl4";
const STRING_DB_USER        = "signl4";

$m = mysqli_connect(STRING_DB_HOST, STRING_DB_USER, STRING_DB_PASS);
mysqli_select_db($m, STRING_DB_NAME);

// SQL
$sSql = "SELECT 
		   CONCAT('Temparature Alert on ', `MachineName`) AS 'Subject', 
		   `MachineName` AS 'Machine', 
		   MAX(Temperature) AS 'Temperature' 
		 FROM MachineData 
		 WHERE Timestamp > DATE_ADD(NOW(), INTERVAL -" . INT_TIME . " MINUTE) 
		   AND Temperature > " . INT_TEMPERATURE . " 
		 GROUP BY `MachineName`";

// Fetch data from DB
$oRes = mysqli_query($m, $sSql);

while ($aTuple = mysqli_fetch_assoc($oRes)) {
    $sTuple = json_encode($aTuple);
    triggerSignl($sTuple);
}

mysqli_close($m);

function triggerSignl($sData) {
    $c = curl_init(STRING_SIGNL4_URL);
    curl_setopt($c, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($c, CURLOPT_POSTFIELDS, $sData);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($sData)));
	
	// SIGNL4 call
    print_r(curl_exec($c));
    
	curl_close($c);
}
