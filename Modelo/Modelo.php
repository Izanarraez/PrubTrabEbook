<?php

/**
 * Performs CRUD operations.
 */
class Modelo {
  private mysqli $conn;

  /**
   * Creates a new Model object linked to the specified table.
   * The model automatically connects to the database specified
   * by the connection constants.
   * 
   * @param string  $table  Table to perform CRUD actions against.
   * 
   * @return bool Returns whether the connection succeeded or not.
   */
  public function __construct() {
    $this->conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Check for errors in connection.
    return $this->conn->connect_errno ? false : true;
  }

  /**
   * Performs a SELECT operation against the database.
   * 
   * @param string  $statement  Prepared SQL statement of the query.
   *                            Example: " id=? AND units>? "
   * @param array   $values     Array of values to use during the prepare. 
   *                            One value per '?' present in the statement.
   * 
   * @return array Associative array of the rows retrieved from the query.
   */
  public function select(string $table, string $statement = '1=?', array $values = array('1')) {
    $sql = "SELECT * FROM " . $table . " WHERE " . $statement;
    $statement = $this->conn->prepare($sql);
    $statement->execute($values);

    $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);
    return $result;
  }

  /**
   * Inserts a new row into the database. All the array's
   * properties will be inserted into the database.
   * 
   * @param mixed $array  Associative array of values to insert
   *                      into the database.
   * 
   * @return bool Returns whether or not the object was 
   *              successfully inserted into the database.
   */
  public function insert(string $table, array $array) {
    $sql = "INSERT INTO  $table ";
    $fields = "(";
    $statement = "(";
    $values = array();

    foreach ($array as $key => $value) :
      $fields .= $key . ',';
      $statement .= "?,";
      array_push($values, $value);
    endforeach;

    $sql .= preg_replace('/.$/', ')', $fields) . " VALUES " . preg_replace('/.$/', ')', $statement);
    $statement = $this->conn->prepare($sql);

    return $statement->execute($values);
  }

  /**
   * Updates an entry from the database based on the id. 
   * The id property of the object must be set.
   * 
   * 
   * @return bool Returns whether or not the entry was 
   *              successfully updated the database.
   */
  public function update(string $table, array $data, $id) {
    $values     = array_values($data);
    $setFields  =  join(',', array_map(
      function ($val) {
        return $val . '=?';
      },
      array_keys($data)
    ));

    $sql        = "UPDATE $table SET $setFields WHERE $id = $data[$id]";
    $statement  = $this->conn->prepare($sql);

    return $statement->execute($values);
  }


  /**
   * ! NO REVISADO 
   * Deletes an entry from the database based on the id. 
   * The id property of the object must be set.
   * 
   * @param mixed $obj  Object to delete from the database.
   * 
   * @return bool Returns whether or not the entry was 
   *              successfully deleted from the database.
   */
  public function delete(string $table, $obj) {
    $data = get_object_vars($obj);
    if (!$data['id']) return false;

    $sql = 'DELETE FROM ' . $table . ' WHERE id = ?';
    $statement = $this->conn->prepare($sql);

    return $statement->execute(array($data['id']));
  }

  /**
   * ! NO REVISADO 
   * Closes the connection to the database.
   */
  public function close() {
    return $this->conn->close();
  }

  /**
   * Checks the login credentials.
   */
  public function checkLogin(string $mail, string $password) {
    $mail = $this->sanitize($mail);
    $password = $this->sanitize($password);

    $sql = "SELECT * FROM " . TABLE_USERS . "
            INNER JOIN " . TABLE_PASSWORDS . "
            ON " . TABLE_USERS . "." . USER_ID . " = " . TABLE_PASSWORDS . "." . PASSWORD_ID . "
            WHERE " . PASSWORD_VALUE . " = '" . $password . "'
              AND	" . USER_EMAIL . " = '" . $mail . "';";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    $result = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

    return sizeof($result) == 1;
  }

  /**
   * Gets all the personal info present in the database related to a user.
   * 
   * @param string $mail E-mail address linked to the user's account.
   * 
   * @return array Associative array of the data stored in the database.
   */
  public function getUser(string $mail) {
    $mail = $this->sanitize($mail);

    $sql = "SELECT * FROM " . TABLE_USERS . "
            INNER JOIN " . TABLE_USER_DATA . "
            ON " . TABLE_USERS . "." . USER_ID . " = " . TABLE_USER_DATA . "." . DATA_ID . "
            WHERE " . USER_EMAIL . " = '" . $mail . "';";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    return $statement->get_result()->fetch_assoc();
  }


  public function getBook(string $id) {
    $id = $this->sanitize($id);

    $sql = "SELECT  libros.id, libros.titulo, libros.subtitulo, libros.resumen
            FROM `libros`
              INNER JOIN libros_autores ON libros.id = libros_autores.id_libro
              INNER JOIN libros_generos ON libros.id = libros_generos.id_libro
              INNER JOIN autores ON libros_autores.id_autor = autores.id
              INNER JOIN generos ON libros_generos.id_genero = generos.id
            WHERE libros.id = " . $id . ";";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    return $statement->get_result()->fetch_assoc();
  }

  public function getBookAuthors(string $id) {
    $id = $this->sanitize($id);

    $sql = "SELECT autores.id, autores.nombre as nombre 
            FROM `libros_autores`
              INNER JOIN autores ON libros_autores.id_autor = autores.id
            WHERE libros_autores.id_libro = " . $id . ";";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function getBookGenres(string $id) {
    $id = $this->sanitize($id);

    $sql = "SELECT generos.id, generos.nombre FROM `libros_generos`
              INNER JOIN generos ON libros_generos.id_genero = generos.id
            WHERE libros_generos.id_libro =" . $id . ";";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function getBookFile(string $id) {
    $id = $this->sanitize($id);

    $sql = "SELECT  libros_formatos_idiomas.id, libros_formatos_idiomas.titulo,
                    libros_formatos_idiomas.id_formato as formato, idiomas.idioma, 
                    libros_formatos_idiomas.archivo,libros_formatos_idiomas.portada,
                    libros_formatos_idiomas.paginas, libros_formatos_idiomas.isbn,
                    libros_formatos_idiomas.precio
            FROM `libros`
              INNER JOIN libros_formatos_idiomas ON libros.id = libros_formatos_idiomas.id_libro
              INNER JOIN idiomas ON libros_formatos_idiomas.id_idioma = idiomas.id
            WHERE libros.id =" . $id . ";";

    $statement = $this->conn->prepare($sql);
    $statement->execute();
    return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function searchBookIDs(string $row,  string $data, int $offset = 0, int $max_rows = 20) {
    $data = $this->sanitize($data);

    $sql = "SELECT * FROM ( 
              SELECT  libros.id, libros_formatos_idiomas.titulo as titulo,
                      autores.nombre as autor, generos.nombre as genero,
                      libros_formatos_idiomas.isbn, idiomas.idioma, libros_formatos_idiomas.id_formato as formato
              FROM libros
                LEFT JOIN libros_generos ON libros_generos.id_libro = libros.id
                LEFT JOIN libros_autores ON libros_autores.id_libro = libros.id
                LEFT JOIN libros_formatos_idiomas ON libros_formatos_idiomas.id_libro = libros.id
                LEFT JOIN autores ON libros_autores.id_autor = autores.id
                LEFT JOIN generos ON libros_generos.id_genero = generos.id
                LEFT JOIN idiomas ON libros_formatos_idiomas.id_idioma = idiomas.id) AS book
            WHERE UPPER($row) LIKE CONCAT('%', UPPER(?), '%')
            GROUP BY id ORDER BY id
            LIMIT $offset, $max_rows;";

    $statement = $this->conn->prepare($sql);
    $statement->execute(array($data));
    return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function findBook(string $title, string $author) {
    $title = $this->sanitize($title);
    $author = $this->sanitize($author);

    $sql = "SELECT libros.id FROM libros
            INNER JOIN libros_autores ON libros_autores.id_libro = libros.id
            INNER JOIN autores ON libros_autores.id_autor = autores.id
            WHERE libros.titulo   LIKE  ?
              AND autores.nombre  LIKE  ?;";

    $statement = $this->conn->prepare($sql);
    $statement->execute(array($title, $author));
    return $statement->get_result()->fetch_all(MYSQLI_ASSOC);
  }

  public function sanitize(string $str) {
    return preg_replace('/\'/', "''", $str);
  }
}
