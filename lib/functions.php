<?php
require_once('./utility');

// get the envkey key
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

// require envkey-wp.php in wp-config.php
function editConfig ($configFile, $envkeyLink) {
	if (strpos(file_get_contents($configFile), $envkeyLink) === false) {
		echo '<li>🔗  linking envkey-wp.php to wp-config.php</li>' . PHP_EOL;
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

// delete or disable key in wp-config.php file
function killKey ($deleteMode, $configFile, $key) {
	if (strpos(file_get_contents($configFile), $key) !== false) {
		$lineNumber = false;
		if ($handle = fopen($configFile, 'r')) {
		  $count = -1;
		  while (($line = fgets($handle, 4096)) !== false and !$lineNumber) {
		    $count++;
		    $lineNumber = (strpos($line, $key) !== false) ? $count : $lineNumber;
		  }
		  fclose($handle);
		}
		$fileOut = file($configFile);

		if ($deleteMode) {
			echo '<li>🗑  erasing ' . $key . ' from wp-config.php</li>' . PHP_EOL;
			unset($fileOut[$lineNumber]);
		} else {
			if (isComment($fileOut[$lineNumber]) === false) {
				echo '<li>🕶  disabling ' . $key . ' in wp-config.php</li>' . PHP_EOL;
				$fileOut[$lineNumber] = '// ' . $fileOut[$lineNumber];
			} else {
				echo '<li>🕶  ' . $key . ' is disabled in wp-config.php</li>' . PHP_EOL;
			}
		}

		file_put_contents($configFile, implode('', $fileOut));
	} else {
		echo '<li>🔑  ' . $key . ' does not exist in wp-config.php</li>' . PHP_EOL;
	}
}

// exec envkey and return json
function getVars ($key, $checks, $siteBase) {
	if ($checks) {
		$envVars = exec('envkey-fetch --cache --cache-dir ' . $siteBase . '.envkey/cache ' . $key);
		return $envVars;
	} else {
		return null;
	}
}

// for each key in array -> define(key, value); if key exists in wp-config, delete or comment out
function setVars ($envKey, $checks, $deleteMode, $configFile, $siteBase) {
	$envVars = getVars($envKey, $checks, $siteBase);
	if (isJson($envVars)) {
		$envVars = json_decode($envVars, true);
		// print_r($envVars);
		foreach ($envVars as $key => $value) {
			echo '<li>✍️  assigning ' . $key . '</li>' . PHP_EOL;
    	define($key, $value);
			killKey ($deleteMode, $configFile, $key);
		}
	} else {
		echo '<li>🚫  envkey output is invalid</li>' . PHP_EOL;
	}
}