<?php

/**
 * Opens a Google Drive service
 * @param array $config Config variables
 * @return Zend_Gdata_Spreadsheets: Opened Service
 */
function openDriveService($config)
{
// load Zend Gdata libraries
require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

// set credentials for ClientLogin authentication
$user = $config['drive_user'];
$pass = $config['drive_pass'];

try {
	// connect to API
	$service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;
	$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
	$service = new Zend_Gdata_Spreadsheets($client);
	}
	catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}
	return $service;
}

/** Gets worksheet contents as rows
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 * @return array: Rows of the selected worksheet
 */
function getWorksheetContentsAsRows($service, $config)
{
    try {
	$wsEntry = $service->getWorksheetEntry(
			'https://spreadsheets.google.com/feeds/worksheets/'.$config['ssid'].'/private/full/'.$config['wsid']);
    } catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}	
	return $wsEntry->getContentsAsRows();	
}

/** Inserts a new row in the worksheet
 * @param array $row Row to be inserted
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function appendWorksheetRow($row, $service, $config)
{
	// set target spreadsheet and worksheet
	$ssKey = $config['ssid'];
	$wsKey = $config['wsid'];

	try {
		// insert new row
		$service->insertRow($row, $ssKey, $wsKey);
	}
	catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}	
}

/** Updates new row in the worksheet
 * @param int $id Ordinal of the row to be updated
 * @param array $row New row
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function updateWorksheetRow($id, $row, $service, $config)
{
	// set target spreadsheet and worksheet
	$ssKey = $config['ssid'];
	$wsKey = $config['wsid'];

	try {
		// get the row matching query
		$query = new Zend_Gdata_Spreadsheets_ListQuery();
		$query->setSpreadsheetKey($ssKey);
		$query->setWorksheetId($wsKey);
		$listFeed = $service->getListFeed($query);

		$listEntry = $listFeed->offsetGet($id);
		$service->updateRow($listEntry, $row);
	}
	catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}
}

/** Deletes row in the worksheet
 * @param int $id Ordinal of the row to be deleted
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function deleteRowFromFile($id, $service, $config)
{
	// set target spreadsheet and worksheet
	$ssKey = $config['ssid'];
	$wsKey = $config['wsid'];
	
	try {
		// get the row matching query
		$query = new Zend_Gdata_Spreadsheets_ListQuery();
		$query->setSpreadsheetKey($ssKey);
		$query->setWorksheetId($wsKey);
		$listFeed = $service->getListFeed($query);

		$listEntry = $listFeed->offsetGet($id);
		$service->deleteRow($listEntry);
	}
	catch (Exception $e) {
		die('ERROR: ' . $e->getMessage());
	}	
}
?>
