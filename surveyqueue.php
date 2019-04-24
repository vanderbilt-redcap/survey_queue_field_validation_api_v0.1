<?php
$module->checkApiToken();

global $post;

$project_id = db_escape($post['projectid']);

if($project_id == "") die();

