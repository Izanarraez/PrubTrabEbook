<?php

require_once('Control/Validation.php');
require_once('Modelo/Modelo.php');
require_once('Modelo/Book.php');

class EbookAPI {

  private Modelo $model;

  function __construct() {
    $this->model = new Modelo();
  }

  /**
   * Querries the database for a set amount of books.
   * @param array $data Key/Value pairs of search constraints.
   * @param int $amount Max number of books to retrieve.
   * @return array Collection of book objects.
   */
  public function getBooks(int $amount = 20) {
    $books = array();
    $key = "titulo";
    $val = isset($data[$key]) ? $data[$key] : "";

    $ids = (new Modelo())->searchBookIDs($key, $val);

    foreach ($ids as $id) {
      $book = new Book($id['id']);
      $book = $book->getData();
      $books = array_merge($books, array($book));
    }

    return json_encode($books);
  }

  /** Returns a book object. */
  public function getBook(string $id) {
    $book = new Book($id);
    $book->loadData();
    return json_encode(array('book' => $book->getData()));
  }

  function manage_book(array $data, array $raw_files) {
    if (isset($data['id'])) :
      $book = new Book($data['id']);
      $book->update($data, $raw_files);
    else :
      $book = new Book();
      $book->insert($data, $raw_files);
    endif;

    // return $book->getData();
    return $data['id'] ? $book->getData() : "pitos";
  }

  /** Adds a new book to the database. */
  public function addBook(object $data) {
  }



  /** Updates a pre-existing book in the database. */
  public function updateBook(object $data, $id) {
    $book = new Book($id);

    foreach ($data as $datum) :

    endforeach;

    // titulo
    // subtitulo
    // resumen
  }

  /**
   * Permite buscar libros en base a:
   * - id
   * - titulo
   * - autor
   * - genero
   * - ISBN
   * - idioma
   * - formato
   * @param array $data 
   * @return json Array of book objects.
   */
  public function search(array $data) {
    $books = array();
    $key = isset(array_keys($data)[0]) ? array_keys($data)[0] : "titulo";
    $val = isset($data[$key]) ? $data[$key] : "";

    $ids = (new Modelo())->searchBookIDs($key, $val);

    foreach ($ids as $id) {
      $book = new Book($id['id']);
      $book->loadData();
      $books = array_merge($books, array($book->getData()));
    }

    return json_encode($books);
  }

  public function getLanguages() {
    $data  = (new Modelo())->select('idiomas');
    return json_encode($data);
  }

  public function getCategories() {
    $raw  = (new Modelo())->select('generos');
    $data = array_map(
      function ($category) {
        $img = base64_encode($category['imagen']);
        $category['imagen'] = $img;
        return $category;
      },
      $raw
    );
    return json_encode($data);
  }

  /** Adds a new book to the database. */
  public function addCategory(array $raw_data, array $raw_files) {
    $data     = parse('genre', $raw_data);
    $image    = isset($raw_files['imagen']) ? $raw_files['imagen'] : null;
    $errors   = (new DataValidator($this->model))->validate_genre($data);
    $success  = sizeof($errors) == 0;

    if ($success) :
      // TODO error failsafe
      $this->model->insert('generos', array_merge(
        $data,
        array('imagen' => file_get_contents($image['tmp_name']))
      ));
      http_response_code(200);
      die();
    endif;

    // Message construction
    $message = array('success' => $success);
    if (!$success)      $message = array_merge($message, array('errors' =>  $errors));

    return json_encode($message);
  }
}
