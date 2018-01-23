<?php

// settings
$mode = 'comment';
$siteBase = '/Dev/envkey-wp/';
$wpBase = '/Dev/envkey-wp/';

// paths
$siteBase = $_SERVER['HOME'] . $siteBase;
$wpBase = $_SERVER['HOME'] . $wpBase;
$envFile = $siteBase . '/.env';

// wp-config
$configFile = $wpBase . '/wp-config.php';
$wpConfig = file_get_contents($configFile);

// envkey
$envkeyMap = $wpBase . '/envkey-wp.php';
$envkeyLink = 'require_once(ABSPATH . \'envkey-wp.php\');';

function getKey ($env) {
	$envData = fopen($env, 'r');
	while (!feof($envData)) {
		$currLine = fgets($envData);
  	if (strpos($currLine, 'ENVKEY') !== false) {
			// echo 'envKey line: ' . $currLine . '\n';
			$envKey = explode('=', $currLine)[1];
			// echo 'envkey: ' . $envKey . '\n';
			return $envKey;
		} else {
			return null;
		}
  }
	fclose($envData);
}