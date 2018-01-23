<?php

function isJson ($str) {
  json_decode($str);
  return (json_last_error() == JSON_ERROR_NONE);
}

function isComment($str) {
  $str = trim($str);
  $first_two_chars = substr($str, 0, 2);
  $last_two_chars = substr($str, -2);
  return $first_two_chars == '//' || substr($str, 0, 1) == '#' || ($first_two_chars == '/*' && $last_two_chars == '*/');
}