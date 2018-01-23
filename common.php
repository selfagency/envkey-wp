<?php
require_once('./settings.php');
require_once('./utility.php');
require_once('./checks.php');

// paths
$siteBase = $_SERVER['HOME'] . $siteBase;
$wpBase = $_SERVER['HOME'] . $wpBase;
$envFile = $siteBase . '.env';

// wp-config
$configFile = $wpBase . '/wp-config.php';
$wpConfig = file_get_contents($configFile);
$envkeyLink = 'require_once(ABSPATH . \'envkey-wp.php\');';

// checks
$checks = checks($envFile, $configFile, $wpConfig, $envkeyLink);

function getKey ($env) {
	$envData = fopen($env, 'r');
	while (!feof($envData)) {
		$currLine = fgets($envData);
  	if (strpos($currLine, 'ENVKEY') !== false) {
			$envKey = explode('=', $currLine)[1];
			return $envKey;
		} else {
			return null;
		}
  }
	fclose($envData);
}