<?php
$module->checkApiToken();

$sql = "select validation_name as validation_type, validation_label, data_type as validation_type_class, regex_php as regex, regex_js from redcap_validation_types";

$q = db_query($sql);

if($e = db_error()) {
	throw new Exception("Database error while pulling redcap validation types.");
}

$validationTypes = [];
// format sql records
while($row = db_fetch_assoc($q)) {
	$record = [];
	foreach(array_keys($row) as $key) {
		$record[$key] = $row[$key];
	}
	$validationTypes[] = $record;
	unset($record);
}

$content = json_encode($validationTypes);

// send the response to the requestor
RestUtility::sendResponse(200, $content, $format);