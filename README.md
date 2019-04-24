# survey_queue_field_validation_api_v0.1
Turns on survey queue information and input field validation endpoints for the REDCap API.

## Usage
To enable this extension to the REDCap API, module must be enabled on the Control Center of REDCap.

Additionally, this module must be enabled on each project before it can be used there.

Calls to this API are almost identical to the REDCap API, with the following changes.
1. URL must include the following GET parameters: prefix=[this_module_prefix], type=module, NOAUTH, page=[surveyqueue|fieldvalidation], pid=[project_id]