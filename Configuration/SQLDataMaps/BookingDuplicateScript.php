<?php
/*
 * This script gets rid of duplicates within the tx_ttlogon_registrations table
 *
 *
 * WICHTIG: zuerst 
 *
 *
 *
 *
 */

$mysqli = new mysqli("localhost", "root", "secret", "typo3");

/*
* Create Querys for each Kursprogramm!
*/
// Select all Kursprogramme
$selectPrograms = 'SELECT tx_ttlogon_sessions.uid 
FROM tx_ttlogon_sessions 
WHERE tx_ttlogon_sessions.deleted != 1;';
$result = $mysqli->query($selectPrograms);

//Iterate all Kursprogramme and create a selection for all registrations with the same name
$selectDuplicates = array();

while ($row = $result->fetch_assoc()) {
	$selectDuplicates[] = "
	SELECT 
     GROUP_CONCAT(tx_ttlogon_registrations.uid) AS uids,
     GROUP_CONCAT(tx_ttlogon_registrations.eventid) AS eids,
     COUNT(*) AS cnt
FROM 
     tx_ttlogon_registrations
WHERE
     tx_ttlogon_registrations.deleted = 0
     AND
     tx_ttlogon_registrations.event_group = ".$row['uid']."
GROUP BY 
     tx_ttlogon_registrations.name HAVING cnt > 1;";
}
$result->free();
//print_r($selectDuplicates);

/*
* Now, Go through and put the uid's in the first booking
*/

$sqlUpdate = array();
$sqlDelete = array();

foreach ($selectDuplicates as $sqlStatement){
	//print_r($sqlStatement);
	if($result = $mysqli->query($sqlStatement)){
	//print_r($result2);

		while ($row2 = $result->fetch_assoc()) {

			$uid = explode (',',$row2['uids']);
			$sqlUpdate[] = 'UPDATE tx_ttlogon_registrations SET tx_ttlogon_registrations.eventid = "'.$row2['eids'].'" WHERE tx_ttlogon_registrations.uid = "'.array_shift($uid).'";';

			//print_r($row2);

			foreach ($uid as $u) {
				$sqlDelete[] = 'DELETE FROM tx_ttlogon_registrations WHERE tx_ttlogon_registrations.uid = "'.$u.'";';
				//print_r($sqlDelete);
			}
		}
		$result->free();
	} else {
		echo ('Kein Duplicate in Programm'. $sqlStatement.'

			');
	}
	
}

//print_r($sqlUpdate);
//print_r($sqlDelete);



if($sqlUpdate){
	foreach ($sqlUpdate as $statement) {
	$res = $mysqli->query($statement);
	echo('UPDATE OK<br />');
	}
	
} else {
	echo ('$sqlUpdate ist leer.');
}

if($sqlDelete){
	foreach ($sqlDelete as $statement2) {
	$res =  $mysqli->query($statement2);
	echo('DELETE DONE<br />');

	}
}else {
	echo ('$sqlDelete ist leer.');
}


?>