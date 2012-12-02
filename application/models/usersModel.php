<?php

/** Upload photo in uploads
 * @param array $_FILES Array FILES
 * @param array $config Config variables
 * @return string: Final filename of the photograph
 */
function uploadImage($_FILES, $config)
{
	$destination = $config['uploadDirectory']."/".$_FILES['photo']['name'];
	$filename = $_FILES['photo']['tmp_name'];
	
	$path_parts = pathinfo($destination);
	$name=$path_parts['basename'];
	
	$i=0;
	while(in_array($name,scandir($config['uploadDirectory'])))
	{
		$i++;	
		$name=$path_parts['filename']."_".$i.".".$path_parts['extension'];
	}
	
	$destination = $config['uploadDirectory']."/".$name;
	move_uploaded_file($filename, $destination);
	return $name;
}

/** Update photo in uploads
 * @param array $_FILES Array FILES
 * @param int User id
 * @param array $config Config variables
 * @return string: Filename of the new photo
 */
function updateImage($_FILES, $id, $service, $config)
{
	$arrayUser=readUser($id, $service, $config);
	$image=trim($arrayUser['photo']);
	if(!$_FILES['photo']['error'])
	{
		unlink($config['uploadDirectory']."/".$image); // deletes old photo
		$image=uploadImage($_FILES, $config);		   // uploads new photo
	}
	return $image;
}

/** Write user to the worksheet
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param string $imageName Final filename of the photograph
 * @param array $config Config variables
 */
function writeToWorksheet($service, $imageName, $config)
{
	$arrayUser = array_merge(initArrayUser(),$_POST);
			
	foreach($arrayUser as $key => $value)
	{
		if(is_array($value))
			$value=implode(',',$value);
		$arrayUser[$key]=trim($value);
	}	
	$arrayUser['photo']=$imageName;
	
	appendUserToWorksheet($arrayUser, $service, $config);
}

/** Update user in worksheet
 * @param int $id User id
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param string $imageName Photo filename
 * @param array $config Config variables
 */
function updateToWorksheet($id, $service, $imageName, $config)
{
	$arrayUser = array_merge(initArrayUser(),$_POST);
		
	foreach($arrayUser as $key => $value)
	{
		if(is_array($value))
			$value=implode(',',$value);
		$arrayUser[$key]=trim($value);
	}	
	$arrayUser['photo']=$imageName;
	
	updateUserToWorksheet($id, $arrayUser, $service, $config);
}

/** Read users from worksheet
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 * @return array: Users array
 */
function readUsersFromWorksheet($service, $config)
{
	$arrayUsers = getWorksheetContentsAsRows($service, $config);
	
	// Replace all <br /> tags by the CR+LF sequence
	foreach ($arrayUsers as $row_idx => $row)
		foreach($row as $key => $value)
			$arrayUsers[$row_idx][$key] = str_replace("<br />", "\r\n", $value);

	return $arrayUsers;
}

/** Append user to worksheet
 * @param array $arrayUser User array
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function appendUserToWorksheet($arrayUser, $service, $config)
{
	// Since line feeds are allowed in form textareas, but are not allowed in
	// a Google spreadsheet, we replace those line feeds with the <br /> tag
	$sustituye = array("\r\n","\n\r","\n","\r");
	foreach($arrayUser as $key => $value)
		$arrayUser[$key] = str_replace($sustituye, "<br />", nl2br($value));
	
	appendWorksheetRow($arrayUser, $service, $config);
}

/** Append user to file
 * @param int $id User id
 * @param array $arrayUser User array
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function updateUserToWorksheet($id, $arrayUser, $service, $config)
{
	// Since line feeds are allowed in form textareas, but are not allowed in
	// a Google spreadsheet, we replace those line feeds with the <br /> tag
	$sustituye = array("\r\n","\n\r","\n","\r");
	foreach($arrayUser as $key => $value)
		$arrayUser[$key] = str_replace($sustituye, "<br />", nl2br($value));

    updateWorksheetRow($id, $arrayUser, $service, $config);
}

/**
 * Read user from worksheet to array
 * @param int $id Usr id
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 * @return array: User array
 */
function readUser($id, $service, $config)
{
	// Read users
	$arrayUsers=readUsersFromWorksheet($service, $config);
	// Select data of user $id
	$arrayUser=$arrayUsers[$_GET['id']];
	return($arrayUser);
}

/**
 * Initialize user array
 * @return array: User array initialized
 */
function initArrayUser()
{
	$keys=array('id','name','email','password','description','pets','city','coder','languages');
	$arrayUser=array();
	foreach($keys as $key)
		$arrayUser[$key]=NULL;
	return $arrayUser;
}

/**
 * Delete user from worksheet and image from directory
 * @param int $id User id
 * @param Zend_Gdata_Spreadsheets $service Google Drive service
 * @param array $config Config variables
 */
function deleteUser($id, $service, $config)
{
	$arrayUser = readUser($id, $service, $config);
	
	// Delete user photo
	$image = $arrayUser['photo'];
	unlink($config['uploadDirectory']."/".$image);

	// Deletes user from worksheet
	deleteRowFromFile($id, $service, $config);
}
?>
