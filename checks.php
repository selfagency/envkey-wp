<?php
function checks($envFile, $configFile, $wpConfig) {
  // check if envkey-fetch is installed
  exec('which envkey-fetch', $which);
  if ($which != null && $which[0] != null) {
    $check01 = true;
  } else {
    $check01 = false;
  };
  echo 'envkey-fetch is installed: ' . ($check01 ? 'true' : 'false') . '\n';

  // check if .env file exists with envkey field
  if (file_exists($envFile)) {
    $check02 = true;
    if (strpos(file_get_contents($envFile), 'ENVKEY') !== false) {
      $check03 = true;
      $envKey = getKey($envFile);
      if ($envKey != null) {
        $check04 = true;
      } else {
        $check04 = false;
      }
    } else {
      $check03 = false;
    }
  } else {
    $check02 = false;
  };
  echo '.env exists: ' . ($check02 ? 'true' : 'false') . '\n';
  echo 'envkey field exists: ' . ($check03 ? 'true' : 'false') . '\n';
  echo 'environment key exists: ' . ($check04 ? 'true' : 'false') . '\n';

  // check if envkey file is linked in wp-config.php
  // file exists
  if (file_exists($configFile)) {
    $check05 = true;
    // is writable
    if (is_writable($configFile)) {
      $check06 = true;
      // envkey is linked
      $envkeyLink = 'require_once(ABSPATH . \'envkey-wp.php\');\n';
      if (strpos(file_get_contents($configFile), $envkeyLink) !== false) {
        $check07 = true;
      } else {
        $wpConfig = $envkeyLink . $wpConfig;
        file_put_contents($configFile, $wpConfig);
        $check07 = true;
      }
    } else {
      $check06 = false;
    }
  } else {
    $check05 = false;
  }
  echo 'wp-config.php exists: ' . ($check05 ? 'true' : 'false') . '\n';
  echo 'wp-config.php is writable: ' . ($check06 ? 'true' : 'false') . '\n';
  echo 'envkey is linked to wp-config.php: ' . ($check07 ? 'true' : 'false') . '\n';

  if ($check01 && $check02 && $check03 && $check04 && $check05 && $check06 && $check07) {
    $checks = true;
  } else {
    $checks = false;
  }

  return $checks;
}
