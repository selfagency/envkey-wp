<?php
require_once('./checks.php');

// settings
$deleteMode = false; // delete replaced lines or comment out
$siteBase = '/Dev/envkey-wp/'; // where you .env is
$wpBase = '/Dev/envkey-wp/'; // where your wp-config.php is

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
			// echo 'envKey line: ' . $currLine . PHP_EOL;
			$envKey = explode('=', $currLine)[1];
			// echo 'envkey: ' . $envKey . PHP_EOL;
			return $envKey;
		} else {
			return null;
		}
  }
	fclose($envData);
}

// require envkey-wp.php in wp-config.php
function editConfig ($configFile, $envkeyLink) {
	if (strpos(file_get_contents($configFile), $envkeyLink) === false) {
		echo '🔗  linking envkey-wp.php to wp-config.php' . PHP_EOL;
		$wpConfig = file($configFile, FILE_IGNORE_NEW_LINES);
		$target = 'require_once(ABSPATH . \'wp-settings.php\');';
		$offset = array_search($target, $wpConfig) -1;
		array_splice($wpConfig, $offset, 0, $envkeyLink);
		file_put_contents($configFile, join(PHP_EOL, $wpConfig));
		if (strpos(file_get_contents($configFile), $envkeyLink) !== false) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}