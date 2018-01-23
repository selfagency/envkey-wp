<?php
require_once('./checks.php');
$checks = checks();
echo 'all checks passed: ' . ($checks ? 'true' : 'false') . '\n';