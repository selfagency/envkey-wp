<?php
function adminPanel($titan) {
	require_once('./common.php');
	require_once('./checks.php');
	$checks = checks($envFile, $configFile, $wpConfig, $envkeyLink, true);

	// admin panel
	$panel = $titan->createAdminPanel(array(
		'name' => 'EnvKey'
	));

	$panel->createOption(array(
		'type' => 'custom',
		'custom' => $checks
	));​;

	$panel->createOption(array(
		'name' => 'Site base',
		'id' => 'site_base',
		'type' => 'text',
		'desc' => 'Location of your .env file relative to your site root. Leave blank if in site root.'
	));

	$panel->createOption(array(
		'name' => 'WordPress base',
		'id' => 'wp_base',
		'type' => 'text',
		'desc' => 'Location of your wp-config.php file relative to your site root. Leave blank if in site root.'
	));

	$panel->createOption(array(
	'name' => 'Delete mode',
	'id' => 'delete_mode',
	'type' => 'select',
	'options' => array(
	'1' => 'On',
	'2' => 'Off'),
	'desc' => 'Delete hardcoded keys from wp-config.php, otherwise comment out.',
	'default' => '2',
	));

	$panel->createOption(array(
	'type' => 'save'
	));
}