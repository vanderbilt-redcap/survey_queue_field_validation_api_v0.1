<?php
namespace Vanderbilt\SurveyQueueFieldValidationAPIExternalModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

class SurveyQueueFieldValidationAPIExternalModule extends AbstractExternalModule
{
	public function checkApiToken() {

		global $post;

		/** @var \RestRequest $data */
		$data = \RestUtility::processRequest(true);

		$post = $data->getRequestVars();
	}
}