<?php
function checks($envFile, $configFile, $wpConfig, $envkeyLink) {
  // check if envkey-fetch is installed
  exec('which envkey-fetch', $which);
  if ($which != null && $which[0] != null) {
    $check01 = true;
  } else {
    $check01 = false;
  };
  echo ($check01 ? '✅' : '🚫') . '  envkey-fetch is installed' . PHP_EOL;

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
  echo ($check02 ? '✅' : '🚫') . '  .env exists' . PHP_EOL;
  echo ($check03 ? '✅' : '🚫') . '  envkey field exists' . PHP_EOL;
  echo ($check04 ? '✅' : '🚫') . '  environment key exists' . PHP_EOL;

  // check if envkey file is linked in wp-config.php
  // file exists
  if (file_exists($configFile)) {
    $check05 = true;
    // is writable
    if (is_writable($configFile)) {
      $check06 = true;
      // envkey is linked
      if (editConfig($configFile, $envkeyLink)) {
        $check07 = true;
      } else {
        $check07 = false;
      }
    } else {
      $check06 = false;
    }
  } else {
    $check05 = false;
  }
  echo ($check05 ? '✅' : '🚫') . '  wp-config.php exists' . PHP_EOL;
  echo ($check06 ? '✅' : '🚫') . '  wp-config.php is writable' . PHP_EOL;
  echo ($check07 ? '✅' : '🚫') . '  envkey is linked to wp-config.php' . PHP_EOL;

  if ($check01 && $check02 && $check03 && $check04 && $check05 && $check06 && $check07) {
    $checks = true;
  } else {
    $checks = false;
  }

  return $checks;
}
