<?php
require_once('./common.php');
$envKey = getKey($envFile);

function getVars ($key) {
	// exec envkey return json
	$envVars = exec('envkey-fetch ' . $key);
	return $envVars;
}

function isJson ($str) {
  // check if json is valid
  json_decode($str);
  return (json_last_error() == JSON_ERROR_NONE);
}

function setVars ($envKey) {
	// for each key in array -> define(key, value); if key exists in wp-config, delete
	$envVars = getVars($envKey);
	if (isJson($envVars)) {
		$envVars = json_decode($envVars, true);
		// print_r($envVars);
		foreach ($envVars as $key => $value) {
			echo 'assigning ' . $value . ' to ' . $key . '\n';
    	define($key, $value);
		}
	} else {
		echo 'JSON is invalid\n';
	}
}

setVars($envKey);