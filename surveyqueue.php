<?php
$module->checkApiToken();

global $post;

$project_id = db_escape($post['projectid']);

if($project_id == "") die();

// get survey_id and form_name info from redcap_surveys using project_id
$sql = "select survey_id, form_name from redcap_surveys where project_id=$project_id";

$q = db_query($sql);

if($e = db_error()) {
	throw new Exception("Database error while pulling redcap survey IDs and form names.");
}

$surveys = [];
$sqlSurveyIdList = [];

// get survey_id and form_name for surveys
while($row = db_fetch_assoc($q)) {
	$sid = $row['survey_id'];
	$sqlSurveyIdList[] = $sid;
	$surveys[$sid] = [
		"form_name" => $row['form_name']
	];
}

if (empty($sqlSurveyIdList)) {
	RestUtility::sendResponse(200, "[]", $format);
}

$sqlSurveyIdList = "(" . implode($sqlSurveyIdList, ', ') . ")";

$sql = "select survey_id, auto_start, condition_surveycomplete_survey_id, condition_surveycomplete_event_id, condition_andor, condition_logic from redcap_surveys_queue where survey_id in $sqlSurveyIdList AND (condition_surveycomplete_survey_id IS NOT NULL OR condition_logic IS NOT NULL)";	

$q = db_query($sql);

if($e = db_error()) {
	throw new Exception("Database error while pulling redcap survey queue conditions.");
}

$surveyQueue = [];

while ($row = db_fetch_assoc($q)) {
	$surveyQueue[] = [
		"queued_survey" => $surveys[$row['survey_id']]['form_name'],
		"completed_survey" => $surveys[$row['condition_surveycomplete_survey_id']]['form_name'],
		"completed_survey_event_id" => $row['condition_surveycomplete_event_id'],
		"separator" => $row["condition_andor"],
		"branching_logic" => $row["condition_logic"],
		"auto_start" => $row['auto_start']
	];
}

$content = json_encode($surveyQueue);

// send the response to the requestor
RestUtility::sendResponse(200, $content, $format);