<?php

require_once('_res/config.php');
require_once('Modelo/Modelo.php');

require_once('_res/config.php');
require_once('Control/EbookAPI.php');
require_once('Control/UserAPI.php');

session_start();

// === ======= ===
// === ROUTING ===
// === ======= ===


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

$parts = preg_split('(\/|\?)', getPath());

/**
 * Will display the URL of the current page.
 * ! Left here just in case it's needed later.
 * @return string The current URL.
 */
function getURL() {
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
  else $link = "http";

  $link .= "://";
  $link .= $_SERVER['HTTP_HOST'];
  $link .= $_SERVER['REQUEST_URI'];

  return $link;
}

// * For Debugging
// header('Content-Type: application/json; charset=utf-8');
// echo json_encode(array(
//   'url'   => getURL(),
//   'path'  => getPath(),
//   'parts' => $parts
// ));

switch ($parts[0]) {
    // PAGES
  case '':
    require_once('Vista/home.php');
    break;
  case 'home':
    header('Location: .');
    break;
  case 'galeria':
    require_once('Vista/galeria.php');
    break;
  case 'acceso':
    require_once('Vista/page_acceso.php');
    break;
  case 'contacto':
    require_once('Vista/contacto.php');
    break;
  case 'nuevo-libro':
    require_once('Vista/formulario_libro.php');
    break;
  case 'libro':
    require_once('Vista/mostrar-libro.php');
    break;
  case 'libros-genero':
    require_once('Vista/libros-genero.php');
    break;
  case 'nuevo-genero':
    require_once('Vista/formulario_genero.php');
    break;
  case "politica-privacidad":
    require_once("Vista/politica-privacidad.php");
    break;
  case "aviso-legal":
    require_once("Vista/aviso-legal.php");
    break;
  case "cookies":
    require_once("Vista/cookies.php");
    break;
  case "carrito":
    require_once("Vista/shopping_cart.php");
    break;
  case "buscador":
    require_once("Vista/buscador.php");
    break;
  case "admin":
    require_once("Vista/administracion.php");
    break;

    // API calls
  case 'user':
    user($parts);
    break;
  case 'book':
    book($parts);
    break;
  case 'category':
    category($parts);
    break;
  case 'languages':
    header('Content-Type: application/json; charset=utf-8');
    echo (new EbookAPI())->getLanguages();
    break;
  case 'search':
    search($parts);
    break;

    // 404
  default:
    http_response_code(404);
    require_once('Vista/404.php');
    break;
}

function user(array $path) {
  $action = isset($path[1]) ? $path[1] : "";
  $userAPI = new UserAPI();

  switch ($action) {
    case 'register':
      header('Content-Type: application/json; charset=utf-8');
      echo $userAPI->register($_POST);
      break;
    case 'login':
      header('Content-Type: application/json; charset=utf-8');
      echo $userAPI->login($_POST);
      break;
    case 'logout':
      $userAPI->logout();
      header("Location: http://" . $_SERVER['HTTP_HOST'] . '/DAW02-EBOOK-STORE/');
      break;
    case 'auth':
      header('Content-Type: application/json; charset=utf-8');
      echo $userAPI->checkLog($_POST);
      break;
    default:
      header('Content-Type: application/json; charset=utf-8');

      if (isset($_GET['get'])) :
        echo $userAPI->search();
        die();
      else :
        echo json_encode("Invalid API call");
        http_response_code(404);
        die();
      endif;
      break;
  }
}

function book(array $path) {
  $action = isset($path[1]) ? $path[1] : "";
  $ebookAPI = new EbookAPI();

  switch ($action) {
    case '':
      header('Content-Type: application/json; charset=utf-8');
      echo $ebookAPI->getBooks();
      break;
    case 'id':
      header('Content-Type: application/json; charset=utf-8');
      echo $ebookAPI->getBook(isset($path[2]) ? $path[2] : "");
      break;
    case 'add':
      http_response_code(200);
      header('Content-Type: application/json; charset=utf-8');
      // var_dump($_FILES);
      echo json_encode($ebookAPI->manage_book($_POST, $_FILES));
      // echo json_encode(file_get_contents('php://input'));
      // echo json_encode($_POST);
      die();
      break;
    case 'update':
    case 'delete':
    default:
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode("Book " . $action . " not yet implemented.");
      http_response_code(404);
      break;
  }
}

function category(array $path) {
  $action = isset($path[1]) ? $path[1] : "";
  $ebookAPI = new EbookAPI();

  switch ($action) {
    case '':
      header('Content-Type: application/json; charset=utf-8');
      echo  $ebookAPI->getCategories();
      break;
    case 'add':
      header('Content-Type: application/json; charset=utf-8');
      echo  $ebookAPI->addCategory($_POST, $_FILES);
      break;
    case 'update':
    case 'delete':
    default:
      if (isset($_GET['get'])) :
        header('Content-Type: application/json; charset=utf-8');
        echo $ebookAPI->search(array('genero' => $action));
        die();
      else :
        require_once('Vista/libros-genero.php');
        die();
      endif;

      // header('Content-Type: application/json; charset=utf-8');
      // echo json_encode("Category " . $action . " not yet implemented.");
      // http_response_code(404);
      break;
  }
}

function search(array $path) {
  header('Content-Type: application/json; charset=utf-8');
  echo (new EbookAPI())->search($_GET);
}
