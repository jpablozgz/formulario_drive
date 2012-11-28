<?php

/** 
 *  Returns the ancestors of a context plus itself (oldest first)
 *  @param array $arrayConfigs Array of all configs per context
 *  @param string $context Context
 *  @return array: Context ancestors array
 */
function contextAncestors($arrayConfigs, $context)
{
	$ancestors = array();

	foreach($arrayConfigs as $key => $value)
	{
		if(strpos($key,':')===FALSE)
			$currentContext = trim($key);
		else
			$currentContext = trim(strstr($key,':',TRUE));
		if (strpos($currentContext, $context)!==FALSE) // $context found!
		{
			$parent = strstr($key,':'); // look for parent
			if ($parent!==FALSE)            // if it has parent, look for ancestors
				$ancestors = contextAncestors($arrayConfigs,trim(substr($parent,1)));
			$ancestors[]= $key;	// appends itself to the list of ancestors
			return $ancestors;
		}
	}	
	return $ancestors;
}

/** 
 *  Read config file to array
 *  @param string $configFile Config filename
 *  @param string $context Context
 *  @return array: Config context array
 */
function readConfig($configFile, $context)
{
	$arrayConfigs = array();
	
	$arrayConfigs = parse_ini_file($configFile, true);
	$ancestors = contextAncestors($arrayConfigs,$context);
	
	$arrayConfig = array();
	foreach($ancestors as $ancestor)
		$arrayConfig = array_merge($arrayConfig,$arrayConfigs[$ancestor]);
	
	return $arrayConfig;
}

/**
 * Renders a view
 * @param string $view View to be rendered
 * @param array $params Parameters of the view
 * @param array $config Config variables
 * @return string Rendered view
 */
function renderView($view, array $params, $config)
{
	ob_start();
	include($config['viewsDirectory']."/".$view.".php");
	$content=ob_get_contents();
	ob_end_clean();
	return $content;
}
?>