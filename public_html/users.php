<?php

define ("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);

require_once("../application/models/applicationModel.php");
require_once("../application/models/usersModel.php");

$config = readConfig('../application/configs/config.ini', 'production');

// Initializing variables
$arrayUser = initArrayUser();

if(isset($_GET['action']))
	$action = $_GET['action'];
else 
	$action = 'select';

switch($action)
{
	case 'update':
		if($_POST)
		{
			$imageName = updateImage($_FILES, $_GET['id'], $config);
			updateToFile($_GET['id'], $imageName, $config);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$arrayUser=readUser($_GET['id'], $config);
		// CAUTION: There is no break; here!!!!!!!!!!
	case 'insert':
		if($_POST)
		{
			$imageName = (!$_FILES['photo']['error'] ? uploadImage($_FILES, $config) : '');
			writeToFile($imageName, $config);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$content = renderView("formulario", array('arrayUser'=>$arrayUser), $config);
		break;
	case 'delete':
		if($_POST)
		{
			if($_POST['submit']=='yes')
				deleteUser($_GET['id'], $config);
			header("Location: users.php?action=select");
			exit();
		}
		else
			$content = renderView("delete", array(), $config);
		break;
	case 'select':
		$arrayUsers = readUsersFromFile($config);
		$content = renderView("select", array('arrayUsers'=>$arrayUsers), $config);
	default:
		break;
}
include("../application/layouts/layout_admin1.php");
?>