<?php
$titan = TitanFramework::getInstance('envkey-wp');
$deleteMode = titan->getOption('delete_mode');
$siteBase = $_SERVER['HOME'] . titan->getOption('site_base');
$wpBase = $_SERVER['HOME'] . titan->getOption('wp_base');
$envFile = $siteBase . '.env';

// wp-config
$configFile = $wpBase . '/wp-config.php';
$wpConfig = file_get_contents($configFile);
$envkeyPath = plugin_dir_path(__FILE__);
$envkeyLink = 'require_once(\'' . $envkeyPath . 'envkey.php\');';

// checks
$checks = checks($envFile, $configFile, $wpConfig, $envkeyLink, false);

// get key
$envKey = getKey($envFile);