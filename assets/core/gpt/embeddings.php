<?php

define('MBG', TRUE);
include($_SERVER['DOCUMENT_ROOT'] . "/functions-new.php");

$embeddings = [];
$courses = [];
$modules = [];

// COURSES
$SQL = $NMAP->prepare("
	    SELECT id, code, title, SUBSTRING(parallel, 2) AS parallel, college, program AS department, status AS network_map 
	    FROM courses
	");
$SQL->execute();
$result = $SQL->get_result();

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {

		$row["modules"] = [];

		$MSQL = $NMAP->prepare("SELECT module_name FROM modules WHERE course = ? ORDER BY module_number");
		$MSQL->bind_param("i", $ROW['id']);
		$MSQL->execute();
		$MResult = $MSQL->get_result();

		while ($MRow = $MResult->fetch_assoc()) {
			$row["modules"][] = $MRow;
		}

		$courses[] = $row;
	}
}
header('Content-Type: application/json');
print_r($courses);
exit();

foreach ($courses as $courseCode => $description) {
	$embeddings["courses"][$courseCode] = generateEmbeddings($description);
}

// MODULES
$SQL = $NMAP->prepare("SELECT * FROM modules");
$SQL->execute();
$result = $SQL->get_result();

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
		$modules[$row["id"]] = "{$row['name']} (Course Code: {$row['course_code']})";
	}
}

foreach ($modules as $moduleId => $moduleDescription) {
	$embeddings["modules"][$moduleId] = generateEmbeddings($moduleDescription);
}


header('Content-Type: application/json');
echo json_encode(["embeddings" => $embeddings], JSON_PRETTY_PRINT);

function generateEmbeddings($text)
{
	global $GPT;
	$data = json_encode(["input" => $text, "model" => "text-embedding-ada-002"]);
	$headers = ["Authorization: Bearer $GPT", "Content-Type: application/json"];

	$ch = curl_init("https://api.openai.com/v1/embeddings");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = json_decode(curl_exec($ch), true);
	curl_close($ch);

	return $response["data"][0]["embedding"] ?? [];
}

?>