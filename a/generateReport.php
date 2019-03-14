<?php
/*
Project: Housekeeping
Author: hjcasayas
Github: https://github.com/hjcasayas/housekeeping
*/


$jsonData = file_get_contents("checklist.json"); //Get json file
$json = json_decode($jsonData, true); //decode json file
$count = count($json['check']); //number of arrays

//loop main list
for ($i=0; $i < $count; $i++) { 

	$subCount = count($json['check'][$i]['sublists']); //sublist array count
	$mainNumber = $i+1; //numbering of the main list
	$mainName = $json['check'][$i]['id']; //id of the main list
	echo 	"<tr class='main-row'>" .
			"<td>" . $mainNumber . "</td>";

				//checks if the mainlist have sublists
				if ($subCount == 0) {
					echo 	"<td colspan='2' class='main-list'>" . $json["check"][$i]["checklist"] . "</td>" .
							"<td>" . "<input type='checkbox' id='$mainName' name='$mainName' class='checkbox-sublist'>" . "<label class='label-checkbox' for='$mainName'>&#x2714</label>" ."</td>" .
							"<td>"; 

							$sql = "SELECT userName FROM $userTable WHERE area = ? AND NOT userName = ? ORDER BY userName ASC";

							$stmt = $conn->prepare($sql);
							$stmt->bind_param("ss", $area, $userName);
							$stmt->execute();

							$results = $stmt->get_result();

							echo "<div class='members-list hide' id='members-$mainName'>";

							while ($rows = $results->fetch_assoc()){
								echo "<input class='checkbox-member' type='checkbox' id='checkbox-member-$mainName-" . $rows['userName'] . "'>" . "<label class='members-label' for='checkbox-member-$mainName-" . $rows['userName'] . "'>" . ucfirst($rows['userName']) . "</label>";
							}

							echo "</div>";


					echo		"</td>" .
							"<td class='comment-tdata' id='comment-$mainName'>" . "</td>";
				} else {	
					echo 	"<td colspan='5' class='main-list'>" . $json["check"][$i]["checklist"] . "</td>";
				}

	echo	"</tr>";



			//Loop sublist
			for ($j=0; $j < $subCount; $j++) { 

				$subNumber = $j+1;
				$name = $json['check'][$i]['sublists'][$j]['id'];

				echo	"<tr>" .
							"<td>" . "</td>" .
							"<td class='subnumber'>" . $mainNumber . "." . $subNumber . "</td>" .
							"<td class='sublist'>" . $json["check"][$i]["sublists"][$j]["sublist"] . "</td>" . 
							"<td>" . "<input type='checkbox' id='$name' name='$name' class='checkbox-sublist'>" . "<label class='label-checkbox' for='$name'>&#x2714</label" . "</td>" .
							"<td>";

							$sql = "SELECT userName FROM $userTable WHERE area = ? AND NOT userName = ? ORDER BY userName ASC";

							$stmt = $conn->prepare($sql);
							$stmt->bind_param("ss", $area, $userName);
							$stmt->execute();

							$results = $stmt->get_result();
							
							echo "<div class='members-list hide' id='members-$name'>";
							
							while ($rows = $results->fetch_assoc()){
								echo "<input class='checkbox-member' type='checkbox' id='checkbox-member-$name-" . $rows['userName'] . "'>" . "<label class='members-label' for='checkbox-member-$name-" . $rows['userName'] . "'>" . ucfirst($rows['userName']) . "</label>";
							}	

							echo "</div>";

				echo		"</td>" . 
							"<td class='comment-tdata' id='comment-$name'>" . "</td>" .
						"</tr>";
			}
}
?>