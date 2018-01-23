<?php
/*
 * Plugin Name: EnvKey for WordPress
 * Version: 0.0.1
 * Plugin URI: https://github.com/selfagency/envkey-wp/
 * Description: Integrate EnvKey with WordPress to manage wp-config.php variables and more.
 * Author: The Self Agency, LLC
 * Author URI: https://self.agency/
 * Requires at least: 4.0
 * Tested up to: 4.0
 *
 * Text Domain: envkey-wp
 *
 * @package WordPress
 * @author The Self Agency, LLC
 * @since 0.0.1
 */

if (!defined('ABSPATH')) exit;
require_once('titan-framework/titan-framework-embedder.php');
require_once('./lib/admin.php');
require_once('./lib/functions.php');

add_action('tf_create_options', 'envkey_options');
function envkey_options () {
	adminPanel($titan);
}

add_action('setup_theme', 'envkey_config');
function envkey_config () {
	require_once('./common.php');
	setVars($envKey, $checks, $deleteMode, $configFile, $siteBase);
}
