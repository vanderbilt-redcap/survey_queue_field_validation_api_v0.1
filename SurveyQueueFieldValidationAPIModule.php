<?php
namespace Vanderbilt\SurveyQueueFieldValidationAPIModule;

use ExternalModules\AbstractExternalModule;
use ExternalModules\ExternalModules;

class SurveyQueueFieldValidationAPIModule extends AbstractExternalModule
{
	public function checkApiToken() {
		global $post;

		// /** @var \RestRequest $data */
		$data = \RestUtility::processRequest(true);

		$post = $data->getRequestVars();
	}
}