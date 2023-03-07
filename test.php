<?php


/**
 * @return string The current path.
 */
function getPath() {
  $url = strtolower($_SERVER['REQUEST_URI']);
  $root = str_replace("\\", "/", $_SERVER['DOCUMENT_ROOT']);
  $dir = str_replace("\\", "/", __DIR__);
  $root = str_replace("$root", "",  $dir);
  $root = strtolower($root) . '/';
  $result = str_replace($root, '', $url);
  return rawurldecode($result);
}

// $parts = explode('/', getPath());
$parts = preg_split('(\/|\?)', getPath());

header('Content-Type: application/json; charset=utf-8');
echo json_encode([
  '$_POST' => $_POST,
  '$_GET' => $_GET,
  "file_get_contents('php://input')" => file_get_contents('php://input'),
  '$_FILES' => $_FILES,
  '__FILE__' => __FILE__,
  '__DIR__' => __DIR__,
  '$_SERVER["REQUEST_URI"]' => $_SERVER['REQUEST_URI'],
  '$_SERVER["DOCUMENT_ROOT"]' => $_SERVER['DOCUMENT_ROOT'],
  '$_SERVER["REQUEST_URI"] replaced' => str_replace('/DAW02-EBOOK-STORE/', '', $_SERVER['REQUEST_URI']),
  '$parts' => $parts
]);
