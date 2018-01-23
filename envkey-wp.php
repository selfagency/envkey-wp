<?php
require_once('./common.php');
$envKey = getKey($envFile);

function getVars ($key, $checks) {
	// exec envkey return json
	if ($checks) {
		$envVars = exec('envkey-fetch ' . $key);
		return $envVars;
	} else {
		return null;
	}
}

function isJson ($str) {
  // check if json is valid
  json_decode($str);
  return (json_last_error() == JSON_ERROR_NONE);
}

function setVars ($envKey, $checks, $deleteMode, $configFile) {
	// for each key in array -> define(key, value); if key exists in wp-config, delete
	$envVars = getVars($envKey, $checks);
	if (isJson($envVars)) {
		$envVars = json_decode($envVars, true);
		// print_r($envVars);
		foreach ($envVars as $key => $value) {
			echo '✍️  assigning ' . $value . ' to ' . $key . PHP_EOL;
    	define($key, $value);
			killKey ($deleteMode, $configFile, $key);
		}
	} else {
		echo '🚫  json is invalid' . PHP_EOL;
	}
}

setVars($envKey, $checks, $deleteMode, $configFile);